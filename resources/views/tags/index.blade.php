@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin: 0px 0px 60px 0px">
    <h1 >Select Tags to Study</h1>

    <form action="{{ route('study.initiate') }}" method="POST" style=" margin-left: auto; margin-right: auto; width: 100%;">
        @csrf
        @foreach ($tags as $tag)
            <label class="chip" style="margin: 5px; align-items: center;" >
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                {{ $tag->name }}
                <span class="checkmark"></span>
            </label>
        @endforeach
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; ">
        <button type="submit" class="btn-submit">Study Selected Tags</button>
       </div>
    </form>
</div>
@endsection
