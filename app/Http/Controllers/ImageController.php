<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $path = storage_path('app/public/tmp/uploads');

        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('image');

        $name = uniqid().'_'.trim($file->getClientOriginalName());

        $file->move($path, $name);

        return ['name' => $name];
    }

    public function getData(Book $book)
    {
        return [];
        // $images = $book->images;
        // return ['media' => $images];
    }
}
