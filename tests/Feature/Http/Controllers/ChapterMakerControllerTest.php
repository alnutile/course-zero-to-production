<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Facades\App\ChapterMaker\ChapterMakingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Cashier\Subscription;
use Tests\TestCase;

class ChapterMakerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pass_in_book()
    {
        $user = User::factory()->create();
        $sub = Subscription::factory()->create(
            ['user_id' => $user->id]
        );

        $book = Book::factory()->create([
            'title' => 'Zen and the art of coding',
            'owner_id' => $user->id,
        ]);

        ChapterMakingRepository::shouldReceive('handle')
            ->once()
            ->andReturn('foo');

        $this->actingAs($user)
            ->post(route('chapter.maker.generate.idea', [
                'book' => $book->id,
            ]), [
                'context' => 'Can you write a chapter for my book it is about learning how to code. It is science fiction. The main character is a teanager. Write in the style of "L Ron Hubbard"',
            ])
            ->assertOk();
    }
}
