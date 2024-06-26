<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\InitialCardController;
use App\Http\Controllers\StudyController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/complete', function () {
    return view('complete');
})->name('complete');

Route::resource('cards', FlashcardController::class)->middleware('auth');
Route::resource('answers', AnswerController::class);
Route::resource('tags', TagController::class);

Route::post('/study', [StudyController::class, 'initiateStudy'])->name('study.initiate');
Route::post('/study/continue', [StudyController::class, 'continueStudy'])->name('study.continue');
Route::get('normal-show/{card}/', [FlashcardController::class, 'normal_show'])->name('cards.normal_show');
Route::get('/initial-cards', [InitialCardController::class, 'initialCard'])->name('initial-cards');







Route::get('/dashboard', function () {
    return redirect()->route('cards.index');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

