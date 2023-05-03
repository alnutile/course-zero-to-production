<?php

namespace Tests\Feature;

use App\Models\User;
use Facades\App\ExampleClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_example_api_client()
    {

        $data = get_fixture('example.json');
        Http::fake([
            'api.openai.com/*' => Http::response($data, 200),
        ]);
        $results = ExampleClient::getData();

        $this->assertNotNull($results);
    }

    public function test_teams_can_be_created(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post('/teams', [
            'name' => 'Test Team',
        ]);

        $this->assertCount(2, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->fresh()->ownedTeams()->latest('id')->first()->name);
    }
}
