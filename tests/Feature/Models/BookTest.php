<?php

namespace Tests\Feature\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory()
    {
        $model = Book::factory()->create();
        $this->assertNotNull($model->title);
    }

    public function test_rel()
    {
        $user = User::factory()->create();

        $book = Book::factory()->create([
            'owner_id' => $user->id,
        ]);

        $this->assertCount(1, $user->books);

        $this->assertEquals($user->id, $book->owner->id);
    }

    public function test_book_image_path() {
        $book = Book::factory()->create([
            'title' => "aBCD BOOK"
        ]);
        $path = 'https://ui-avatars.com/api/?name=A&color=7F9CF5&background=EBF4FF';

        $this->assertEquals($path, $book->book_image_path);
    }

    public function test_cover_image_field() {
        $this->markTestSkipped("@TODO");
    }
}
