<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;
use App\Models\User;
use App\Support\Response\Messages;
use App\Http\Requests\Posts\DestroyRequest;
use App\Http\Controllers\Admin\Resources\PostController;

class DestroyTest extends TestCase
{
    /**
     * @test
     */
    public function the_destroy_method_uses_destroy_request()
    {
        $this->assertActionUsesFormRequest(
            PostController::class,
            'destroy',
            DestroyRequest::class
        );
    }

    /** @test */
    public function a_user_with_permissions_can_delete_their_posts()
    {
        $user = $this->authorUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('success', __(Messages::POST_DELETED))
        ;

        $this->assertSoftDeleted($post);
    }

    /** @test */
    public function a_user_with_permissions_cannot_delete_posts_that_do_not_belong_to_him()
    {
        $post = Post::factory()->for(User::factory()->create())->create();

        $this
            ->actingAs($this->authorUser())
            ->delete(route('admin.posts.destroy', $post))
            ->assertForbidden()
        ;
    }

    /** @test */
    public function a_post_in_the_trash_can_not_be_deleted_again()
    {
        $post = Post::factory()->for(
            $user = $this->authorUser()
        )->trashed()->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post))
            ->assertNotFound()
        ;
    }

    /** @test */
    public function a_user_without_permissions_cannot_delete_their_posts()
    {
        $user = $this->authorUser()->removePermissions('delete-posts');
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post))
            ->assertForbidden()
        ;
    }
}
