<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
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
            'books' => BookResource::collection(Book::latest()->get()),
        ]);
    }

    public function show(Book $book)
    {

        return inertia('Books/Show', [
            'book' => new BookResource($book),
            'subscriptions' => [
                'default' => auth()->user()->subscribed('default'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return inertia('Books/Create', [
                'book' => new Book(),
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
            request()->session()->flash('flash.banner', 'Sorry there was an error');
            request()->session()->flash('flash.bannerStyle', 'error');

            return back();
        }

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

        try {
            $validate['owner_id'] = auth()->user()->id;
            $book = Book::create($validate);
            $request->session()->flash('flash.banner', 'Book Created');

            return to_route('books.show', [
                'book' => $book->id,
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
            request()->session()->flash('flash.banner', 'Sorry there was an error');
            request()->session()->flash('flash.bannerStyle', 'danger');

            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        if (request()->user()->cannot('update', $book)) {
            abort(403);
        }

        return inertia('Books/Edit', [
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        if ($request->user()->cannot('update', $book)) {
            abort(403);
        }

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
