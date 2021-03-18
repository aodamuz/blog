<?php

namespace Tests\Feature\Admin\Resources\Posts\Validation;

use App\Models\Post;
use Illuminate\Support\Str;
use Tests\Feature\Admin\Resources\Posts\TestCase;

class TitleTest extends TestCase
{
    /** @test */
    public function a_post_title_requires_a_minimun_length()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => Str::random(2)
            ]))
            ->assertSessionHasErrors('title')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'title' => Str::random(2)
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function the_title_of_a_post_requires_a_maximum_length()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => Str::random(61)
            ]))
            ->assertSessionHasErrors('title')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'title' => Str::random(61)
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function a_post_requires_a_title()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => null
            ]))
            ->assertSessionHasErrors('title')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'title' => null
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function the_title_of_a_post_must_be_a_string()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => 1234567890
            ]))
            ->assertSessionHasErrors('title')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'title' => 1234567890
            ]))
            ->assertSessionHasErrors('title')
        ;
    }
}
