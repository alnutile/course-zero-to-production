<?php

namespace App\Http\Controllers;

use Facades\App\ChapterMaker\ChapterMakingRepository;
use App\Models\Book;
use Facades\App\OpenAi\ClientWrapper;

class ChapterMakerController extends Controller
{
    public function getChapterIdea(Book $book)
    {
        $validate = request()->validate([
            'context' => ['required', 'max:1000'],
        ]);

        try {
            $chapterSuggestion = ChapterMakingRepository::handle($book, $validate['context']);

            request()->session()->flash('flash.banner', 'Chapter Generated');

            return response()->json([
                'context' => $chapterSuggestion,
            ], 200);
        } catch (\Exception $e) {
            logger('Error');
            logger($e->getMessage());

            return response()->json([], 422);
        }
    }
}
