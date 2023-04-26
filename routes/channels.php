<?php

use App\Models\Book;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('books.{book_id}', function ($user, $book_id) {
    logger('Book coming '.$book_id);
    $book = Book::findOrFail($book_id);

    return $book->owner_id === $user->id;
});
