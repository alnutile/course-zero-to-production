<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Facades\App\OpenAi\ClientWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpenAiGenerateImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_openai_generates_image()
    {
        ClientWrapper::shouldReceive('setTokens->generateTldr')
            ->once()
            ->andReturn('Some tldr');

        ClientWrapper::shouldReceive('setSize->generateImage')
            ->once()
            ->andReturn('Some content here');

        $user = User::factory()->create();

        //act
        $this->actingAs($user)
            ->post(route('openai.images'), [
                'content' => 'foo bar',
            ])->assertStatus(200);
    }
}
