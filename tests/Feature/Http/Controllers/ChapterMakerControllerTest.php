<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Facades\App\OpenAi\ClientWrapper;
use App\OpenAi\Facades\OpenAiWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use OpenAI\Laravel\Facades\OpenAI;
use Tests\TestCase;

class ChapterMakerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pass_in_book() {
        $book = Book::factory()->create([
            'title' => "Zen and the art of coding"
        ]);
        $user = User::factory()->create();

        ClientWrapper::shouldReceive('generate')->andReturn("Some content here");

        $this->actingAs($user)
            ->post(route("chapter.maker.generate.idea", [
            'book' => $book->id
        ]), [
            'context' => 'Can you write a chapter for my book it is about learning how to code. It is science fiction. The main character is a teanager. Write in the style of "L Ron Hubbard"'
            ])
            ->assertOk();
    }
}