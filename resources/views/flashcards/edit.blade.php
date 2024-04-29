@extends('layouts.app')

@section('content')
    <h1>Edit Flashcard</h1>
    <form action="{{ route('flashcards.update', $flashcard->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="front">Front:</label>
            <input type="text" name="front" id="front" value="{{ $flashcard->front }}" required>
        </div>
        <div>
            <label for="back">Back:</label>
            <input type="text" name="back" id="back" value="{{ $flashcard->back }}" required>
        </div>
        <div>
            <label for="tags">Tags (comma separated):</label>
            <input type="text" name="tags" id="tags" value="{{ implode(',', $flashcard->tags->pluck('name')->toArray()) }}">
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
