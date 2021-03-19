<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;
use App\Models\User;
use App\Support\Response\Messages;

class SoftDeletesTest extends TestCase
{
    /** @test */
    public function a_post_can_be_deleted() {
        $user = $this->globalUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post))
            ->assertSessionHas('success', __(Messages::POST_DELETED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertSoftDeleted($post);
    }

    /** @test */
    public function a_post_can_be_deleted_if_the_user_is_the_author() {
        $user = $this->authorUser();
        $post1 = Post::factory()->for($user)->create();
        $post2 = Post::factory()->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post1))
            ->assertSessionHas('success', __(Messages::POST_DELETED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertSoftDeleted($post1);

        $this
            ->delete(route('admin.posts.destroy', $post2))
            ->assertForbidden()
        ;

        $this->assertDatabaseHas('posts', ['id' => $post2->id]);
    }

    /** @test */
    public function a_post_can_be_deleted_if_the_user_is_an_admin() {
        $user = $this->adminUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post))
            ->assertSessionHas('success', __(Messages::POST_DELETED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertSoftDeleted($post);
    }

    /** @test */
    public function a_post_can_be_deleted_if_the_user_is_a_super_admin() {
        $user = $this->globalUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post))
            ->assertSessionHas('success', __(Messages::POST_DELETED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertSoftDeleted($post);
    }

    /** @test */
    public function a_post_can_be_deleted_if_the_user_is_a_post_manager() {
        $user = $this->user()->assignPermissions(['access', 'post-manager']);
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.destroy', $post))
            ->assertSessionHas('success', __(Messages::POST_DELETED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertSoftDeleted($post);
    }

    /** @test */
    public function a_post_can_be_restored() {
        $user = $this->globalUser();
        $post = Post::factory()->trashed()->for($user)->create();

        $this->assertSoftDeleted($post);

        $this
            ->actingAs($user)
            ->patch(route('admin.posts.restore', $post))
            ->assertSessionHas('success', __(Messages::POST_RESTORED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertFalse($post->fresh()->trashed());
    }

    /** @test */
    public function a_post_can_only_be_restored_if_it_is_in_the_trash() {
        $user = $this->globalUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->patch(route('admin.posts.restore', $post))
            ->assertForbidden()
        ;

        $this->assertFalse($post->fresh()->trashed());
    }

    /** @test */
    public function a_post_can_be_permanently_deleted() {
        $user = $this->globalUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.delete', $post))
            ->assertSessionHas('success', __(Messages::POST_PERMANENTLY_DELETED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertDatabaseMissing('posts', [
            'id' => $post->getRouteKey(),
        ]);
    }

    /** @test */
    public function a_post_can_be_permanently_deleted_only_if_the_user_is_a_super_admin() {
        $user = $this->adminUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.delete', $post))
            ->assertForbidden()
        ;

        $this->assertDatabaseHas('posts', [
            'id' => $post->getRouteKey(),
        ]);

        $user = User::factory()->create()->assignRole('author');

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.delete', $post))
            ->assertForbidden()
        ;

        $this->assertDatabaseHas('posts', [
            'id' => $post->getRouteKey(),
        ]);

        $user = User::factory()->create()->assignRole('global');

        $this
            ->actingAs($user)
            ->delete(route('admin.posts.delete', $post))
            ->assertSessionHas('success', __(Messages::POST_PERMANENTLY_DELETED))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertDatabaseMissing('posts', [
            'id' => $post->getRouteKey(),
        ]);
    }
}
