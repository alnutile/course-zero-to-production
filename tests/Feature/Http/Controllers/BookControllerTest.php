<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    public function test_index()
    {
        //setup
        $user = User::factory()->create();

        Book::factory()->count(2)->create();

        //act
        $this->actingAs($user)
            ->get(route('books.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Books/Index')
                ->has('books')
                ->has('books.data', 2)
            );
    }

    public function test_create_screen()
    {
        //setup
        $user = User::factory()->create();

        //act
        $this->actingAs($user)
            ->get(route('books.create'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Books/Create'));
        //assert
    }

    public function test_show_screen()
    {
        //setup
        $user = User::factory()->create();
        $book = Book::factory()->create();

        //act
        $this->actingAs($user)
            ->get(route('books.show', [
                'book' => $book->id,
            ]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Books/Show'));
        //assert
    }

    public function test_update_book_should_fail()
    {
        $hacker = User::factory()->create();
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'owner_id' => $user->id,
        ]);

        //act
        $route = route('books.update', [
            'book' => $book->id,
        ]);

        $this->actingAs($hacker)
            ->put($route, [
                'title' => 'test',
                'isbn' => 12345,
                'owner_id' => $book->owner_id,
            ])->assertStatus(403);
    }

    public function test_edit_fail_non_owner()
    {
        //setup
        $hacker = User::factory()->create();
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'owner_id' => $user->id,
        ]);

        //act
        $this->actingAs($hacker)
            ->get(route('books.edit', [
                'book' => $book->id,
            ]))
            ->assertStatus(403);
        //assert
    }

    public function test_edit_form()
    {
        //setup
        $user = User::factory()->create();
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'owner_id' => $user->id,
        ]);

        //act
        $this->actingAs($user)
            ->get(route('books.edit', [
                'book' => $book->id,
            ]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Books/Edit'));
        //assert
    }

    public function test_create_book()
    {
        $user = User::factory()->create();

        //act
        $this->assertDatabaseCount('books', 0);
        $this->actingAs($user)
            ->post(route('books.store'), [
                'title' => 'test',
                'isbn' => 12345,
                'owner_id' => $user->id,
            ]);
        $this->assertDatabaseCount('books', 1);
    }

    public function test_update_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'owner_id' => $user->id,
        ]);

        //act
        $route = route('books.update', [
            'book' => $book->id,
        ]);

        $this->actingAs($user)
            ->put($route, [
                'title' => 'test',
                'isbn' => 12345,
                'owner_id' => $book->owner_id,
            ])->assertRedirectToRoute(
                'books.edit', [
                    'book' => $book->id,
                ]
            );

        $this->assertEquals('test', $book->refresh()->title);
        $this->assertEquals('12345', $book->refresh()->isbn);
    }

    public function test_update_book_and_media()
    {

        $user = User::factory()->create();
        $book = Book::factory()->create([
            'owner_id' => $user->id,
            'title' => 'Foobar',
        ]);

        //act
        $route = route('books.update', [
            'book' => $book->id,
        ]);

        $data = get_fixture('media.json');

        $this->actingAs($user)
            ->put($route, $data)->assertRedirectToRoute(
                'books.edit', [
                    'book' => $book->id,
                ]
            );

        $this->assertEquals('Test 2', $book->refresh()->title);
        $this->assertEquals('8888', $book->refresh()->isbn);
    }

    public function test_create_book_and_adds_owner_id()
    {
        $user = User::factory()->create();

        //act
        $this->assertDatabaseCount('books', 0);
        $this->actingAs($user)
            ->post(route('books.store'), [
                'title' => 'test',
                'isbn' => 12345,
            ]);
        $this->assertDatabaseCount('books', 1);
    }

    public function test_only_owners_see_their_books()
    {
        $this->markTestSkipped('@TODO');
    }
}
