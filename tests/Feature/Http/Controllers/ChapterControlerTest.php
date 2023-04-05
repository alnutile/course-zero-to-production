<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChapterControlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_make_chapter()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $this->assertDatabaseCount('chapters', 0);
        $this->actingAs($user)
            ->post(route('chapters.create', [
                'book' => $book->id,
            ]), [
                'content' => 'Foo bar',
            ]);

        $this->assertDatabaseCount('chapters', 1);
    }
}
