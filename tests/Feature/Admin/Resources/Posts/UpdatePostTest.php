<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use App\Support\Response\Messages;

class UpdatePostTest extends TestCase
{
    /** @test */
    public function a_user_with_permissions_can_update_posts()
    {
        $user = $this->authorUser();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('posts', ['user_id' => $user->id]);

        $this
            ->actingAs($user)
            ->from(route('admin.posts.edit', $post))
            ->put(route('admin.posts.update', $post), $this->data())
            ->assertRedirect(route('admin.posts.edit', $post))
            ->assertSessionHas('success', __(Messages::POST_UPDATED))
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'user_id' => $user->id
        ]));
    }

    /** @test */
    public function the_slug_of_a_post_can_be_updated()
    {
        $slug = 'a-slug-edited';
        $user = $this->authorUser();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertNotEquals($slug, $post->slug);

        $this
            ->actingAs($user)
            ->put(route('admin.posts.update', $post), $this->data(
                compact('slug')
            ))
            ->assertSessionDoesntHaveErrors()
        ;

        $this->assertEquals($slug, $post->fresh()->slug);
    }

    /** @test */
    public function a_posts_manager_can_change_an_author() {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $post->user->id);

        // Action to change the author.
        // =====================================

        // This is the new author.
        $user = User::factory()->create();

        $postManager = User::factory()->create()->assignRole('admin');

        $this
            ->actingAs($postManager)
            ->put(route('admin.posts.update', $post), $this->data([
                'user_id' => $user->id
            ]))
            ->assertSessionHasNoErrors()
        ;

        $this->assertEquals($user->id, $post->fresh()->user->id);
    }
}
