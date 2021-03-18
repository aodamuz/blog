<?php

namespace Tests\Feature\Admin\Resources\Posts\Validation;

use App\Models\Post;
use Illuminate\Support\Str;
use Tests\Feature\Admin\Resources\Posts\TestCase;

class DescriptionTest extends TestCase
{
    /** @test */
    public function the_description_of_a_post_is_required()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => ''
            ]))
            ->assertSessionHasErrors('description')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'description' => ''
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_must_be_a_string()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => 1234567890
            ]))
            ->assertSessionHasErrors('description')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'description' => 1234567890
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_requires_a_minimum_length()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => Str::random(9)
            ]))
            ->assertSessionHasErrors('description')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'description' => Str::random(9)
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_requires_a_maximum_length()
    {
        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => Str::random(161)
            ]))
            ->assertSessionHasErrors('description')
        ;

        $post = Post::factory()->for($user)->create();

        $this
            ->put(route('admin.posts.update', $post), $this->data([
                'description' => Str::random(161)
            ]))
            ->assertSessionHasErrors('description')
        ;
    }
}
