<?php

namespace App\Http\Controllers;

use Facades\App\OpenAi\ClientWrapper;

class OpenAiGenerateImageController extends Controller
{
    public function __invoke()
    {
        $validate = request()->validate([
            'content' => ['required'],
        ]);

        $content = ClientWrapper::setTokens(3000)->generateTldr($validate['content']);

        try {
            $question = <<<'EOD'
Can you make an image based on the chapter in this chapter genre sci-fi and photo-realistic steam-punk:
%s

##


EOD;
            $prompt = sprintf($question, $content);

            $image_url = ClientWrapper::setSize('256x256')
                ->generateImage($prompt);

            request()->session()->flash('flash.banner', 'Here is your image');

            return response()->json([
                'image' => $image_url,
            ], 200);

        } catch (\Exception $e) {
            logger('Error');
            logger($e->getMessage());

            return response()->json([], 422);
        }

    }
}
