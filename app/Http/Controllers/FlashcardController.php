<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    /**
     * Display a listing of the flashcards.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flashcards = Flashcard::all();
        return view('flashcards.index', compact('flashcards'));
    }

    /**
     * Show the form for creating a new flashcard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $existingTags = Tag::all();
        return view('flashcards.create', compact('existingTags'));
    }

    /**
     * Store a newly created flashcard in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
        ]);
    
        $flashcard = Flashcard::create([
            'front' => $request->front,
            'back' => $request->back,
        ]);
    
        // Process tags
        $tags = explode(',', $request->tags);
        foreach ($tags as $tagName) {
            $tagName = trim($tagName);
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $flashcard->tags()->attach($tag);
        }
    
        return redirect()->route('flashcards.index')
            ->with('success', 'Flashcard created successfully.');
    }
    

    /**
     * Display the specified flashcard.
     *
     * @param  \App\Models\Flashcard  $flashcard
     * @return \Illuminate\Http\Response
     */
    public function show(Flashcard $flashcard)
    {
        return view('flashcards.show', compact('flashcard'));
    }

    /**
     * Show the form for editing the specified flashcard.
     *
     * @param  \App\Models\Flashcard  $flashcard
     * @return \Illuminate\Http\Response
     */
    public function edit(Flashcard $flashcard)
    {
        return view('flashcards.edit', compact('flashcard'));
    }

    /**
     * Update the specified flashcard in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flashcard  $flashcard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flashcard $flashcard)
    {
        $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
        ]);

        $flashcard->update([
            'front' => $request->front,
            'back' => $request->back,
        ]);

        // Process tags
        $tags = explode(',', $request->tags);
        $flashcard->tags()->detach(); // Remove all existing tags
        foreach ($tags as $tagName) {
            $tagName = trim($tagName);
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $flashcard->tags()->attach($tag);
        }

        return redirect()->route('flashcards.index')->with('success', 'Flashcard updated successfully.');
    }
}