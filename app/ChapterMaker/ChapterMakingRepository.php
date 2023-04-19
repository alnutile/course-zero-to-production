<?php

namespace App\ChapterMaker;

use App\Models\Book;
use App\Models\Chapter;
use Facades\App\OpenAi\ClientWrapper;

class ChapterMakingRepository
{

    protected array $tldrs_of_chapters = [];

    public function handle(Book $book) {
        /**
         * iterate over chapters
         * get TLDR for each and store in class
         * then send final array to get TLDR of all
         * then send that to get idea
         */
        foreach($book->chapters as $chapter) {
            /** @var Chapter $chapter */
            $this->tldrs_of_chapters[] = ClientWrapper::generateTldr($chapter->content);
        }

        return true;
    }
}
