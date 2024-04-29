<?php

use App\Http\Controllers\TagController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/card/{id}', [FlashcardController::class, 'show'])->name('flashcards.show');
