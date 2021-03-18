<?php

namespace Tests\Feature\Admin\Resources\Posts\Validation;

use App\Models\Post;
use Illuminate\Support\Str;
use Tests\Feature\Admin\Resources\Posts\TestCase;

class BodyTest extends TestCase
{
    /** @test */
    public function the_body_of_a_post_requires_a_minimum_length()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'body' => Str::random(9)
            ]))
            ->assertSessionHasErrors('body')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'body' => Str::random(9)
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    public function a_post_requires_a_body()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'body' => ''
            ]))
            ->assertSessionHasErrors('body')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'body' => ''
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    public function the_body_of_a_post_must_be_a_string()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'body' => 1234567890
            ]))
            ->assertSessionHasErrors('body')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'body' => 1234567890
            ]))
            ->assertSessionHasErrors('body')
        ;
    }
}
