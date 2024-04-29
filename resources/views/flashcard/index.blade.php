@extends('layouts.app')

@section('content')
    <h1>Flashcards</h1>
    <a href="{{ route('flashcards.create') }}" class="btn btn-primary">Create Flashcard</a>
    <ul>
        @foreach ($flashcards as $flashcard)
            <li>
                <strong>Front:</strong> {{ $flashcard->front }}
                <br>
                <strong>Back:</strong> {{ $flashcard->back }}
                <br>
                <strong>Tags:</strong>
                <ul>
                    @foreach ($flashcard->tags as $tag)
                        <li>{{ $tag->name }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('flashcards.destroy', $flashcard->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
