<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;

class InitialCardController extends Controller
{
    public function initialCard()
    {
        $userId = auth()->user()->id;

        $cards = Flashcard::where('user_id', $userId)->get();

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

        return $cards;
    }
}
