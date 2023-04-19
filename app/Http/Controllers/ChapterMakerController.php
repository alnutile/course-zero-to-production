<?php

namespace App\Http\Controllers;

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
            $question = <<<'EOD'
The book title is %s and the context of the chapter is %s
EOD;

            $prompt = sprintf($question,
                $book->title,
                $validate['context'],
            );

            $context = ClientWrapper::completions($prompt);

            request()->session()->flash('flash.banner', 'Chapter Generated');

            return response()->json([
                'context' => $context,
            ], 200);
        } catch (\Exception $e) {
            logger('Error');
            logger($e->getMessage());

            return response()->json([], 422);
        }
    }
}
