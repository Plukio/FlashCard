@extends('layouts.app')

@section('content')
    <h1>Tags</h1>
    <a href="{{ route('tags.create') }}" class="btn btn-primary">Create Tag</a>
    <ul>
        @forelse ($tags as $tag)
            <li>
                {{ $tag->name }}
                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</button>
                </form>
            </li>
        @empty
            <li>No tags found.</li>
        @endforelse
    </ul>
@endsection
