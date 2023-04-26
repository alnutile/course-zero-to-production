<?php

namespace App\Console\Commands;

use App\Events\ChapterDownGeneratingEvent;
use App\Models\Book;
use Illuminate\Console\Command;

class SendEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $book = Book::find(14);
        ChapterDownGeneratingEvent::dispatch($book, 'Foobar');
    }
}
