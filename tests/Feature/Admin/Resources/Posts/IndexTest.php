<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;

class IndexTest extends TestCase
{
    /** @test */
    public function the_screen_to_see_the_list_of_posts_can_be_rendered()
    {
        $posts = Post::factory(3)->create();

        $response = $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index'))
        ;

        $response
            ->assertOk()
            ->assertViewIs('admin.posts.index')
        ;

        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }
}
