<?php

namespace Tests\Feature\Models;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory()
    {
        $model = Book::factory()->create();
        $this->assertNotNull($model->title);
    }
}
