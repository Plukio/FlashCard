@extends('layouts.app')

@section('title', 'Show Flashcard')

<body>
    <div class="flashcard-container">
        <div class="flashcard" id="flashcard" onclick="flip()">
            <div class="front">
                <div class="tag-container">
                    @foreach ($card->tags as $tag)
                        <div class="tag">{{ $tag->name }}</div>
                    @endforeach
                </div>
                <div class="details">
                    <p>{{ $card->front }}</p>
                </div>
            </div>
            <div class="back">
                <div class="details">
                    <p>{{ $card->back }}</p>
                </div>
            
            </div>
        </div>

        <div class="button-group" style="margin: 100px;"> 
  <button class="button button-black-yellow" onclick="location.href='{{ route('cards.create')}}'">
    <i class="fas fa-edit"></i> 
    <i class="fas fa-plus"></i> Create
  </button>
  <button class="button button-black-yellow" onclick="location.href='{{ route('cards.edit', $card) }}'">
    <i class="fas fa-plus"></i> Edit
  </button>
  <button class="button button-black-yellow" onclick="location.href='{{ route('cards.index') }}'">
    <i class="fas fa-home"></i> 
    <i class="fas fa-plus"></i> Home
  </button>
</div>

</button>

    </div>

    <script>
        function flip() {
            const flashcard = document.getElementById('flashcard');
            flashcard.classList.toggle('flip');
        }

    </script>
</body>
</html>

