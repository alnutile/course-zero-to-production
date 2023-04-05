<?php

namespace App\OpenAi;

use OpenAI\Laravel\Facades\OpenAI;

class ClientWrapper
{

    public function generate($prompt) : string {

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 2000,
            'temperature' => 0
        ]);

        $context = data_get($result, 'choices.0.text');

        return $context;
    }

}
