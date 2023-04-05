<?php

namespace Tests\Feature\Models;

use App\Models\Chapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChapterTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory() {
        $model = Chapter::factory()->create();
        $this->assertNotNull($model->content);
    }

    public function test_relationship() {
        $model = Chapter::factory()->create();
        $this->assertNotNull($model->book->id);
        $this->assertCount(1, $model->book->chapters);
    }
}
