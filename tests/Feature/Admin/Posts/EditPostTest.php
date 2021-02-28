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
        $statuses = PostStatus::all();
        $tags = Tag::factory()->times(3)->create();
        $categories = Category::factory()->times(3)->create();

        $user = $this->authorUser();
        $post = Post::factory()
                    ->for($user)
                    ->create();

        $response = $this
            ->actingAs($user)
            ->get(route('admin.posts.edit', $post))
            ->assertOk()
            ->assertViewIs('admin.posts.edit')
        ;

        $this->assertEquals($statuses, $response['statuses']);
        $this->assertEquals($tags->pluck('title', 'id'), $response['tags']);
        $this->assertEquals(PostStatus::DEFAULT, $response['defaultStatus']);
        $this->assertEquals($categories->pluck('title', 'id'), $response['categories']);
    }
}
