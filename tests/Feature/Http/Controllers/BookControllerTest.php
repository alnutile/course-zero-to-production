<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class BookControllerTest extends TestCase
{


    public function test_index() {
        //setup
        $user = User::factory()->create();

        //act
        $this->actingAs($user)
            ->get(route('books.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Books/Index'));
        //assert
    }

    public function test_only_owners_see_their_books() {
        $this->markTestSkipped("@TODO");
    }
}
