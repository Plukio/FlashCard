<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use App\Models\Tag;
use Carbon\Carbon;
use App\Models\Answer;
use Illuminate\Support\Facades\DB; 



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
    
        // Fetch and check user's cards
        $cards = Flashcard::where('user_id', $userId)
                          ->get();
    
        if ($cards->isEmpty()) {
            Flashcard::create([
                'user_id' => $userId,
                'front' => 'How to start studying flashcards?',
                'back' => 'Click "Study" and select tags you want to study.',
            ]);
    
            Flashcard::create([
                'user_id' => $userId,
                'front' => 'How to edit a flashcard?',
                'back' => 'Click to the flashcard you wish to edit, then you will be see the edit button.',
            ]);
        }
        
        $cards = Flashcard::where('user_id', $userId)->get(); 
    
        $cards = $cards->sortByDesc('created_at'); 
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

        $card->tags()->sync($newTags); 

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
    
        $flashcardsWithTags = Flashcard::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        })->get();
    
    
        if ($flashcardsWithTags->isEmpty()) {
            return redirect()->back()->with('info', 'No cards available to study at this moment.');
        }
    
        $card = $flashcardsWithTags->random();
    
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

        $flashcardsWithTags = Flashcard::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tags.id', $tags); 
        })->get();

        $filteredFlashcards = $flashcardsWithTags->filter(function ($flashcard) {
            return $flashcard->answers()
                            ->where('difficulty_level', 'easy')
                            ->where('created_at', '>=', Carbon::now()->subMinutes(5))
                            ->where('flashcard_id', $flashcard->id) 
                            ->count() < 2;
        });
        
        $filteredFlashcards = $filteredFlashcards->where('id', '!=', $request->flashcard_id);


        if ($filteredFlashcards->isEmpty()) {
            session()->forget('tags'); 
            return redirect()->route('complete');
        }

        
    
        $card = $filteredFlashcards->random();

        return  redirect()->route('cards.show', [
            'card' => $card->id,
            'tags' => $tags 
        ]);
    }
}