<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Books/Index', [
            'books' => Book::latest()->get(),
        ]);
    }

    public function show(Book $book)
    {
        return inertia('Books/Show', [
            'book' => $book->load('owner'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Books/Create', [
            'book' => new Book(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'isbn' => 'nullable',
            'owner_id' => 'nullable',
        ]);

        $validate['owner_id'] = auth()->user()->id;

        Book::create($validate);
        $request->session()->flash('flash.banner', 'Book Created');

        return to_route('books.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return inertia('Books/Edit', [
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'isbn' => ['nullable'],
            'owner_id' => ['required'],
            'completed_at' => ['nullable'],
            'media' => ['nullable'],
        ]);

        $book->update($request->except('media'));

        $request->session()->flash('flash.banner', 'Book Update');

        return to_route('books.edit', [
            'book' => $book->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
