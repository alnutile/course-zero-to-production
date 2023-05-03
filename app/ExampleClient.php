<?php

namespace App;

use Illuminate\Support\Facades\Http;

class ExampleClient
{
    public function getData()
    {
        return Http::get('https://api.openai.com/v1/models')->json();
    }
}
