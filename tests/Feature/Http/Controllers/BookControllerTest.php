<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    public function test_index()
    {
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

    public function test_only_owners_see_their_books()
    {
        $this->markTestSkipped('@TODO');
    }
}
