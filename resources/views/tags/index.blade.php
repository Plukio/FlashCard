@extends('layouts.app')

@section('content')
<div class="tag-container">
    <h1>Select Tags to Study</h1>
    <form action="{{ route('cards.index') }}" method="GET">
        @foreach ($tags as $tag)
            <label class="chip">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                {{ $tag->name }}
                <span class="checkmark"></span>
            </label>
        @endforeach
        <button type="submit" class="btn-submit">Study Selected Tags</button>
    </form>
</div>
@endsection
