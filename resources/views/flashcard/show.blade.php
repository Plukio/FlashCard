@extends('layouts.app')

@section('content')
    <h1>Flashcard Details</h1>
    <div>
        <label for="front">Front:</label>
        <p id="front">{{ $flashcard->front }}</p>
    </div>
    <div>
        <label for="back">Back:</label>
        <p id="back">{{ $flashcard->back }}</p>
    </div>
    <div>
        <label>Tags:</label>
        <ul>
            @forelse ($flashcard->tags as $tag)
                <li>{{ $tag->name }}</li>
            @empty
                <li>No tags available</li>
            @endforelse
        </ul>
    </div>
    <a href="{{ route('flashcards.edit', $flashcard->id) }}">Edit</a> | <a href="{{ route('flashcards.index') }}">Back to list</a>
@endsection
