<?php

namespace App\ChapterMaker;

use App\Models\Book;
use App\Models\Chapter;
use Facades\App\OpenAi\ClientWrapper;

class ChapterMakingRepository
{
    protected array $tldrs_of_chapters = [];

    protected string $finalTldrOfExistingChapters = '';

    protected string $suggestion = "";

    protected Book $book;

    public function handle(Book $book, string $suggestion = ""): string
    {
        $this->book = $book;
        $this->suggestion = $suggestion;

        if(count($this->book->chapters) > 0) {
            $prompt = $this->getPromptForBookWithChapters();
        } else {
            $question = <<<'EOD'
The book title is %s and the author would like you to consider %s.
So as an helpful assistant can you please write the a chapter.
EOD;
            $prompt = sprintf($question,
                $this->book->title,
                $this->suggestion,
            );
        }



        return ClientWrapper::completions($prompt);
    }

    private function getPromptForBookWithChapters()
    {

        foreach ($this->book->chapters as $chapter) {
            /** @var Chapter $chapter */
            $this->tldrs_of_chapters[] = ClientWrapper::generateTldr($chapter->content);
        }

        $finalTldr = implode("\n", $this->tldrs_of_chapters);
        $this->finalTldrOfExistingChapters = ClientWrapper::generateTldr($finalTldr);


        $question = <<<'EOD'
The book title is %s and the context of the chapters prior to this one is %s.
%s
as a helpful assistant can you please write the next chapter using the same style
as the tldrs of the ones included.
EOD;

        $prompt = sprintf($question,
            $this->book->title,
            $this->getSuggestionAsPartOfPrompt(),
            $this->finalTldrOfExistingChapters,
        );

        return $prompt;
    }

    private function getSuggestionAsPartOfPrompt() : string
    {
        if(!$this->suggestion) {
            return $this->suggestion;
        }

        return sprintf("The author would like you to consider %s.", $this->suggestion);
    }


}
