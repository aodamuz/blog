<?php

namespace Tests\Feature\Admin\Posts;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function this() {
        $this->assertTrue(true);
    }
}
