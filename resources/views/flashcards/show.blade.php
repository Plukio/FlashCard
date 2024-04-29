@extends('layouts.app')

@section('content')
    <h1>Flashcard Details</h1>
    <div>
        <label for="front">Front:</label>
        <p id="front">{{ $card->front }}</p>
    </div>
    <div>
        <label for="back">Back:</label>
        <p id="back">{{ $card->back }}</p>
    </div>
    <div>
        <label>Tags:</label>
        <ul>
            @forelse ($card->tags as $tag)
                <li>{{ $tag->name }}</li>
            @empty
                <li>No tags available</li>
            @endforelse
        </ul>
    </div>



    <a href="{{ route('cards.edit', ['card' => $card->id]) }}">Edit</a> | <a href="{{ route('cards.index') }}">Back to list</a>
@endsection
