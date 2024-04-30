@extends('layouts.app')

@section('content')
<div class="flashcard-container" style="padding: 20px 20px 20px 20px;">
    <div class="flashcard" id="flashcard" onclick="flip()">
        <div class="front">
            <h2>Why should you use flash cards?</h2>
            <footer style="position: absolute; bottom: 10px; color: #a9a9a9;">
                Developed by Plug using Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>
        </div>
        <div class="back" style="justify-content: center; text-align: center;">
            <h3>Flashcards force your brain to actively recall information, strengthening memory.</h3>
            <div class="answer-buttons" style="justify-content: center;">
            <button onclick="location.href='{{ route('login') }}'" type="submit" class="login-logout-botton">Lets start</a> 
            </div>
        </div>
    </div>
</div>

<script>
    function flip() {
        const flashcard = document.getElementById('flashcard');
        flashcard.classList.toggle('flip');
    }
</script>
@endsection
