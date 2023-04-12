<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use Facades\App\OpenAi\ClientWrapper;
use Illuminate\Http\Request;

class ChapterControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate(
            ['content' => ['required']]
        );

        $chapter = Chapter::create([
            'book_id' => $book->id,
            'content' => $validated['content'],
            'number' => 1,
        ]);

        request()->session()->flash('flash.banner', 'Chapter Created');

        return to_route('books.show', [
            'book' => $book->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book, Chapter $chapter)
    {
        return inertia('Chapters/Show', [
            'chapter' => $chapter->load('book'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        //
    }

    public function getEditSuggestions()
    {
        $validate = request()->validate([
            'content' => ['required'],
        ]);

            try {
                $question = <<<'EOD'
Can you please check for grammar and touch up the style on this chapter:
%s

##


EOD;
                $prompt = sprintf($question, $validate['content']);

                $content = ClientWrapper::setTokens(3000)
                    ->setTemperature(0.7)
                    ->generate($prompt);

                request()->session()->flash('flash.banner', 'Here are your edits');

                return response()->json([
                    'edits' => $content,
                ], 200);

            } catch (\Exception $e) {
                logger('Error');
                logger($e->getMessage());

                return response()->json([], 422);
        }

    }
}
