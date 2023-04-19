<?php

namespace App\ChapterMaker;

use App\Models\Book;
use App\Models\Chapter;
use Facades\App\OpenAi\ClientWrapper;

class ChapterMakingRepository
{
    protected array $tldrs_of_chapters = [];

    protected string $finalTldrOfExistingChapters = '';

    public function handle(Book $book): string
    {

        /** @phpstan-ignore-next-line */
        foreach ($book->chapters as $chapter) {
            /** @var Chapter $chapter */
            $this->tldrs_of_chapters[] = ClientWrapper::generateTldr($chapter->content);
        }

        $finalTldr = implode("\n", $this->tldrs_of_chapters);
        $this->finalTldrOfExistingChapters = ClientWrapper::generateTldr($finalTldr);

        /** WHAT IS THE SIZE BREAK IT DOWN MORE DEFAULTS 1000 */
        $question = <<<'EOD'
The book title is %s and the context of the chapters prior to this one is %s
as a helpful assistant can you please write the next chapter using the same style
as the tldrs of the ones included.
EOD;

        $prompt = sprintf($question,
            $book->title,
            $this->finalTldrOfExistingChapters,
        );

        return ClientWrapper::completions($prompt);
    }
}
