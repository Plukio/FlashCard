<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;


class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::all();
        return view('answers.index', compact('answers'));
    }

    public function create()
    {
        $flashcards = Flashcard::all();
        return view('answers.create', compact('flashcards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flashcard_id' => 'required|exists:flashcards,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
        ]);

        $flashcard = Answer::create([
            'difficulty_level' => $request->difficulty_level,
            'flashcard_id' => $request->flashcard_id,
            'user_id' => auth()->id(),
        ]);
    

        return redirect()->route('cards.show', ['card' => $request->flashcard_id])
            ->with('success', 'Answer created successfully.');
    }

    public function show(Answer $answer)
    {
        return view('answers.show', compact('answer'));
    }

    public function edit(Answer $answer)
    {
        $flashcards = Flashcard::all();
        return view('answers.edit', compact('answer', 'flashcards'));
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'flashcard_id' => 'required|exists:flashcards,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
        ]);

        $answer->update($request->all());

        return redirect()->route('answers.index')
            ->with('success', 'Answer updated successfully.');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();

        return redirect()->route('answers.index')
            ->with('success', 'Answer deleted successfully.');
    }
}