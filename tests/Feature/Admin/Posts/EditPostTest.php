<?php

namespace Tests\Feature\Admin\Posts;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_edit_post_screen_can_be_rendered()
    {
        $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.edit', Post::factory()->create()))
            ->assertOk()
            ->assertViewIs('admin.posts.edit')
        ;
    }
}
