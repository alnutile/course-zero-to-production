<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Chapter;
use Facades\App\ChapterMaker\ChapterMakingRepository;
use Facades\App\OpenAi\ClientWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ChapterMakingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_iterate_over_chapters()
    {
        $chapter = File::get(base_path('tests/fixtures/example_chapter.txt'));
        ClientWrapper::shouldReceive('generateTldr')
            ->times(3)
            ->andReturns($chapter);

        ClientWrapper::shouldReceive('completions')
            ->once()
            ->andReturns($chapter);
        $book = Book::factory()->create();
        Chapter::factory()->count(2)->create([
            'book_id' => $book,
        ]);

        $results = ChapterMakingRepository::handle($book);
    }

    public function test_gets_final_tldr_of_existing_chapters()
    {
        $chapter = File::get(base_path('tests/fixtures/example_chapter.txt'));
        ClientWrapper::shouldReceive('generateTldr')
            ->times(3)
            ->andReturns($chapter);

        ClientWrapper::shouldReceive('completions')
            ->once()
            ->andReturns($chapter);
        $book = Book::factory()->create();
        Chapter::factory()->count(2)->create([
            'book_id' => $book,
        ]);

        $results = ChapterMakingRepository::handle($book);

        $this->assertNotNull($results);
    }

    public function test_can_use_suggestion()
    {
        $chapter = File::get(base_path('tests/fixtures/example_chapter.txt'));
        ClientWrapper::shouldReceive('generateTldr')
            ->times(3)
            ->andReturns($chapter);

        ClientWrapper::shouldReceive('completions')
            ->once()
            ->withArgs(function($args) {
                return str($args)->contains("Foo bar");
            })
            ->andReturns($chapter);
        $book = Book::factory()->create();

        Chapter::factory()->count(2)->create([
            'book_id' => $book,
        ]);

        $results = ChapterMakingRepository::handle($book, "Foo bar");

        $this->assertNotNull($results);
    }

    public function test_no_chapters()
    {
        $chapter = File::get(base_path('tests/fixtures/example_chapter.txt'));
        ClientWrapper::shouldReceive('generateTldr')
            ->never();

        ClientWrapper::shouldReceive('completions')
            ->once()
            ->withArgs(function($args) {
                return str($args)->contains("Foo bar");
            })
            ->andReturns($chapter);
        $book = Book::factory()->create();

        $results = ChapterMakingRepository::handle($book, "Foo bar");

        $this->assertNotNull($results);
    }
}
