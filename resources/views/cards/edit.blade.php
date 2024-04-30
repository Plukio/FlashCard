@extends('layouts.app')

@section('title', 'Edit Flashcard')

@section('content')
<div style="flex-direction: column; align-items: center; margin: 30px">
    <h1>Edit Flashcard</h1>
    <form action="{{ route('cards.update', $card->id) }}" method="POST" style="width: 100%; max-width: 420px;">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="front">Front of the card:</label>
            <input type="text" name="front" id="front" required class="input-field" placeholder="Enter front text" value="{{ $card->front }}">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="back">Back of the card:</label>
            <input type="text" name="back" id="back" required class="input-field" placeholder="Enter back text" value="{{ $card->back }}">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="tags">Tags (comma separated):</label>
            <!-- Assuming tags are loaded as an array of tag names -->
            <input type="text" name="tags" id="tags" class="input-field" placeholder="Tag1, Tag2, Tag3" value="{{ implode(', ', $card->tags->pluck('name')->toArray()) }}">
        </div>

        <button type="submit" class="button" style="cursor: pointer; background-color: #28a745; color: #ffffff; border: none; padding: 10px 20px; border-radius: 5px;">Update Flashcard</button>
    </form>
</div>
<script>
    document.getElementById('front').focus();
</script>
@endsection
