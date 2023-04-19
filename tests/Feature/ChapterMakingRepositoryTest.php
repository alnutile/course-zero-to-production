<?php

namespace Tests\Feature;

use Facades\App\ChapterMaker\ChapterMakingRepository;
use App\Models\Book;
use App\Models\Chapter;
use Facades\App\OpenAi\ClientWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ChapterMakingRepositoryTest extends TestCase
{

    use RefreshDatabase;

    public function test_iterate_over_chapters() {
        $chapter = File::get(base_path("tests/fixtures/example_chapter.txt"));
        ClientWrapper::shouldReceive('generateTldr')
            ->twice()
            ->andReturns($chapter);
        $book = Book::factory()->create();
        Chapter::factory()->count(2)->create([
            "book_id" => $book
        ]);

        $results = ChapterMakingRepository::handle($book);
    }
}
