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
}
