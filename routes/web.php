<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\TagController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/complete', function () {
    return view('complete');
});

Route::resource('cards', FlashcardController::class);
Route::resource('answers', AnswerController::class);
Route::resource('tags', TagController::class);
Route::post('/study', [FlashcardController::class, 'study'])->name('study');
Route::post('/study/continue', [FlashcardController::class, 'continueStudy'])->name('study.continue');
Route::get('normal-show/{card}/', [FlashcardController::class, 'normal_show'])->name('cards.normal_show');






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

