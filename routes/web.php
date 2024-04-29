<?php

use App\Http\Controllers\FlashcardController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('cards', FlashcardController::class);
