@extends('layouts.app')


@section('title', 'Flashcards')

@section('content')

<div style="width: 100%; max-width: 1000px; margin: 30px auto; padding: 0px 20px 20px 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: relative; overflow: hidden;">
    <div>
        <div style="position: absolute; top: 27px; right: 20px;">
        <a href="{{ route('cards.create') }}" style="padding: 10px 20px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px;">New card</a>
        <a href="{{ route('tags.index') }}" style="padding: 10px 20px; margin: 10px 0px 10px 10px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px;">Study</a>
    </div>
    <div>
    <h1 style="color: #333; top: 20px; right: 20px; ">My Flashcards</h1>
    </div>
    <div style="display: flex; overflow-x: auto; gap: 20px; padding-bottom: 10px;">
        @foreach ($cards as $card)
            <div onclick="location.href='{{ route('cards.normal_show', ['card' => $card->id]) }}'" style="width: 400px; height: 200px; flex: 0 0 auto; padding: 15px; border: 1px solid #ccc; border-radius: 5px; position: relative; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden;">
                <div>
                <div style="display: inline-block; padding: 5px 0px;">
                        @foreach ($card->tags as $tag)
                            <span style="color: #777; background-color: #eef; padding: 2px 5px; margin-right: 5px; border-radius: 3px;">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    <div style= "position: absolute; top: 70px;">
                    <strong>Front:</strong> <span style="color: #555;">{{ $card->front }}</span>
                    <br>
                    </div>
                    <div style="position: absolute; top: 120px;">
                    <strong>Back:</strong> <span style="color: #555;">{{ $card->back }}</span>
                    <br>
                    </div>
                </div>
                <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="position: absolute; bottom: 10px; right: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="padding: 5px 10px; background-color: #dc3545; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
