<?php

namespace Tests\Feature\Admin\Posts;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Support\Enum\PostStatus;
use Database\Seeders\RoleSeeder;
use App\Support\Response\Messages;

class EditPostTest extends TestCase
{
    /** @test */
    public function the_edit_post_screen_can_be_rendered()
    {
        $user = $this->authorUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->get(route('admin.posts.edit', $post))
            ->assertOk()
            ->assertViewIs('admin.posts.create-edit')
        ;
    }

    /** @test */
    public function a_user_without_permission_cannot_edit_posts()
    {
        $user = $this->user()->assignPermissions('access');
        $post = Post::factory()->for($user)->create();

        $this->actingAs($user)->put(
            route('admin.posts.update', $post)
        )->assertForbidden();
    }

    /** @test */
    public function a_user_with_permissions_can_edit_posts()
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
    public function the_slug_of_a_post_can_be_edited()
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
