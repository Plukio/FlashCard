<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use App\Models\Answer;
use Carbon\Carbon;




class StudyController extends Controller
{
      /**
     * Create study session
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function initiateStudy(Request $request)
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
