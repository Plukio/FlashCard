<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use App\Models\Tag;
use Carbon\Carbon;
use App\Models\Answer;



class FlashcardController extends Controller
{
    /**
     * Display a listing of the flashcards.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id; 
        $cards = Flashcard::where('user_id', $userId)->get();

        return view('cards.index', compact('cards'));
    }

   /**
     * Display the specified flashcard with potentially selected tags for context.
     *
     * @param  \App\Models\Flashcard  $card
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Flashcard $card, Request $request)
    {
        $tags = $request->input('tags', []);

        return view('cards.show', compact('card', 'tags'));
    }

    /**
     * Display a listing of the flashcards.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function normal_show(Flashcard $card)
    {

        return view('cards.normal-show', compact('card'));
    }

    /**
     * Show the form for creating a new flashcard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created flashcard in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a flashcard.');
        }


        $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
        ]);
    
        $flashcard = Flashcard::create([
            'front' => $request->front,
            'back' => $request->back,
            'user_id' => auth()->id(),
        ]);
    
        $tags = explode(',', $request->tags);
        foreach ($tags as $tagName) {
            $tagName = trim($tagName);
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $flashcard->tags()->attach($tag);
        }
    
        return redirect()->route('cards.index')
            ->with('success', 'Flashcard created successfully.');
    }
    


    /**
     * Show the form for editing the specified flashcard.
     *
     * @param  \App\Models\Flashcard  $flashcard
     * @return \Illuminate\Http\Response
     */
    public function edit(Flashcard $card)
    {
        return view('cards.edit', compact('card'));
    }

    public function destroy(Flashcard $card)
    {
        $card->delete();
        return redirect()->route('cards.index')
             ->with('success', 'Card deleted successfully.');
    }

    /**
     * Update the specified flashcard in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flashcard  $card 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flashcard $card)
    {
        $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
        ]);

        $card->update([
            'front' => $request->front,
            'back' => $request->back,
        ]);

        $tags = explode(',', $request->tags);
        $currentTagIds = $card->tags->pluck('id')->toArray();
        $newTags = [];

        foreach ($tags as $tagName) {
            $tagName = trim($tagName);
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $newTags[] = $tag->id;
        }

        $card->tags()->sync($newTags); // This is from chatgpt very genius way yo deal with when user add new tag 

        return redirect()->route('cards.index')->with('success', 'Flashcard updated successfully.');
    }


      /**
     * Create study session
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function study(Request $request)
    {
        $tags = $request->tags;
    
        if (empty($tags)) {
            return redirect()->back()->with('error', 'No tags selected for studying.');
        }
    
        $flashcards = Flashcard::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        })->with(['answers' => function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subHours(3));
        }])->get();
    
        $filteredCards = $flashcards->filter(function ($card) {
            return $card->answers->isEmpty() || !$card->answers->every(function ($answer) {
                return $answer->answer === 'easy';
            });
        });
    
        if ($filteredCards->isEmpty()) {
            return redirect()->back()->with('info', 'No cards available to study at this moment.');
        }
    
        $card = $filteredCards->random();
    
        return redirect()->route('cards.show', [
            'card' => $card->id,
            'tags' => $tags  
        ]);
    }


    
    /**
   * Create and continue study session
   *
   * @param  \Illuminate\Http\Request  $request
   */
    public function continueStudy(Request $request)
    {
        $tags = json_decode($request->tags);

        Answer::create([
            'flashcard_id' => $request->flashcard_id,
            'user_id' => auth()->id(),
            'difficulty_level' => $request->difficulty_level,
        ]);

        $flashcards = Flashcard::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('id', $tags);
        })->with(['latestAnswer' => function ($query) {
            $query->latest()->take(1);
        }, 'recentAnswers' => function ($query) {
            $query->where('created_at', '>=', now()->subHours(3));
        }])->get();
    
        $filteredCards = $flashcards->filter(function ($card) {
            if ($card->answers->isEmpty()) {
                return true;
            }
            return !$card->answers->every(function ($answer) {
                return $answer->answer === 'easy';
            });
        });
    
        if ($filteredCards->isEmpty()) {
            session()->forget('tags');  
            return redirect()->back()->with('success', 'You have mastered all selected flashcards.');
        }
    
        $card = $filteredCards->random();

        return  redirect()->route('cards.show', [
            'card' => $card->id,
            'tags' => $tags 
        ]);
    }
}