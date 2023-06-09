<?php

namespace App\Http\Controllers;

use App\Jobs\SendChapterMakerJob;
use App\Models\Book;

class ChapterMakerController extends Controller
{
    public function getChapterIdea(Book $book)
    {

        //are you a subscriber
        if (! auth()->user()->subscribed('default')) {
            return response()->json('You need to subscribe', 429);
        }

        $validate = request()->validate([
            'context' => ['required', 'max:1000'],
        ]);

        try {

            SendChapterMakerJob::dispatch($book, $validate['context']);

            request()->session()->flash('flash.banner', 'Back in a moment with suggestion');

            return response()->json([
                'context' => '',
            ], 200);
        } catch (\Exception $e) {
            logger('Error');
            logger($e->getMessage());

            return response()->json([], 422);
        }
    }
}
