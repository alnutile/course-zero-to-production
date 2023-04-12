<?php

namespace App\OpenAi;

use OpenAI\Laravel\Facades\OpenAI;

class ClientWrapper
{
    protected int $tokens = 2000;

    protected float $temperature = 0.1;

    public function setTemperature(float $temp)
    {
        $this->temperature = $temp;

        return $this;
    }

    public function setTokens(int $token)
    {
        $this->tokens = $token;

        return $this;
    }

    public function generate($prompt): string
    {
        if (config('openai.mock')) {
            $data = get_fixture('chapter_response.json');

            return data_get($data, 'choices.0.text');
        }

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => $this->tokens,
            'temperature' => $this->temperature,
        ]);

        $context = data_get($result, 'choices.0.text');

        return $context;
    }
}
