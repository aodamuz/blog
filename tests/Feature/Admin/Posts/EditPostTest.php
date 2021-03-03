<?php

namespace Tests\Feature\Admin\Posts;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use App\Support\Enum\PostStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_edit_post_screen_can_be_rendered()
    {
        $user = $this->authorUser();
        $post = Post::factory()
                    ->for($user)
                    ->create();

        $this
            ->actingAs($user)
            ->get(route('admin.posts.edit', $post))
            ->assertOk()
            ->assertViewIs('admin.posts.edit')
        ;
    }
}
