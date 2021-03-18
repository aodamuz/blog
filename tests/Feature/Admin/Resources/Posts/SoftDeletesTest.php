<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;
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

        $this->assertDatabaseHas('posts', [
            'id' => $post->getRouteKey(),
            'deleted_at' => null,
        ]);
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
}
