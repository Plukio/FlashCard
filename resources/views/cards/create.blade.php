@extends('layouts.app')

@section('title', 'Create New Flashcard')

@section('content')
<div style="flex-direction: column; align-items: center; margin: 30px" >
    <h1>Create New Flashcard</h1>
    <form action="{{ route('cards.store') }}" method="POST" style="width: 100%; max-width: 420px;">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="front">Front of the card:</label>
            <input type="text" name="front" id="front" required class="input-field" placeholder="Enter front text">
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="back">Back of the card:</label>
            <input type="text" name="back" id="back" required class="input-field" placeholder="Enter back text">
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="tags">Tags (comma separated):</label>
            <input type="text" name="tags" id="tags" class="input-field" placeholder="Tag1, Tag2, Tag3">
        </div>
        <button type="submit" class="button" style="cursor: pointer; background-color: #28a745; color: #ffffff; border: none; padding: 10px 20px; border-radius: 5px;">Create Flashcard</button>
    </form>
</div>
<script>
    document.getElementById('front').focus();
</script>
@endsection
