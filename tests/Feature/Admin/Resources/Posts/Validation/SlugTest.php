<?php

namespace Tests\Feature\Admin\Resources\Posts\Validation;

use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\Feature\Admin\Resources\Posts\TestCase;

class SlugTest extends TestCase
{
    /** @test */
    public function when_storing_a_posts_slug_should_be_created_automatically()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data())
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'slug' => Str::slug(
                Arr::get($this->data(), 'title')
            ),
        ]));
    }

    /** @test */
    public function when_updating_a_posts_slug_must_be_unique()
    {
        Post::factory()->for(
            $user = $this->authorUser()
        )->create(['slug' => 'test-slug']);

        $post = Post::factory()->for($user)->create(['slug' => 'other-slug']);

        $this
            ->actingAs($user)
            ->put(
                route('admin.posts.update', $post),
                $this->data(['slug' => 'test-slug'])
            )
            ->assertSessionHasErrors('slug');
        ;

        $this->assertEquals('other-slug', $post->fresh()->slug);
    }
}
