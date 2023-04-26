<?php

namespace Tests\Feature;

use App\Events\ChapterDownGeneratingEvent;
use App\Jobs\SendChapterMakerJob;
use App\Models\Book;
use Facades\App\ChapterMaker\ChapterMakingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SendChapterMakerJobTest extends TestCase
{
   use RefreshDatabase;

   public function test_job()
   {
       Event::fake();
       $book = Book::factory()->create([
           'title' => 'Zen and the art of coding',
       ]);

       ChapterMakingRepository::shouldReceive('handle')
           ->once()
           ->andReturn('foo');

       $job = new SendChapterMakerJob($book, 'foobar');
       $job->handle();

       Event::assertDispatched(ChapterDownGeneratingEvent::class);
   }
}
