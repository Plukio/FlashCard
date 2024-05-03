<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Carbon\Carbon;



class TagController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $tags = Tag::whereHas('flashcards', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tags',
        ]);

        Tag::create($request->all());

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }
    
}