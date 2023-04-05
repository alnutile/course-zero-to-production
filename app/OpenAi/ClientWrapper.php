<?php

namespace App\OpenAi;

use OpenAI\Laravel\Facades\OpenAI;

class ClientWrapper
{
    public function generate($prompt): string
    {
        if (config('openai.mock')) {
            $data = get_fixture('chapter_response.json');

            return data_get($data, 'choices.0.text');
        }

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 2000,
            'temperature' => 0,
        ]);

        $context = data_get($result, 'choices.0.text');

        return $context;
    }
}
