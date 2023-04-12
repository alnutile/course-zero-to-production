<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\User;
use Facades\App\OpenAi\ClientWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
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

    public function test_openai_edit()
    {
        ClientWrapper::shouldReceive('setTokens->setTemperature->generate')
            ->once()
            ->andReturn('Some content here');
        $user = User::factory()->create();
        $chapter = Chapter::factory()->create();

        //act
        $this->actingAs($user)
            ->post(route('chapters.openai.suggestions', [
                'chapter' => $chapter->id,
            ]), [
                'content' => $chapter->content,
            ])->assertStatus(200);
    }

    public function test_show_screen()
    {
        //setup
        $user = User::factory()->create();
        $chapter = Chapter::factory()->create();

        //act
        $this->actingAs($user)
            ->get(route('chapters.show', [
                'book' => $chapter->book_id,
                'chapter' => $chapter->id,
            ]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Chapters/Show'));
        //assert
    }
}
