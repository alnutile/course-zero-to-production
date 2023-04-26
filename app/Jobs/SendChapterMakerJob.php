<?php

namespace App\Jobs;

use App\Events\ChapterDownGeneratingEvent;
use App\Models\Book;
use Facades\App\ChapterMaker\ChapterMakingRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendChapterMakerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Book $book, public string $context)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $results = ChapterMakingRepository::handle($this->book, $this->context);

        ChapterDownGeneratingEvent::dispatch($this->book, $results);

    }
}
