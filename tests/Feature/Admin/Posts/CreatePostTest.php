<?php

namespace Tests\Feature\Admin\Posts;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /*
    |-------------------------------------------------------------------------
    | Common
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function create_post_screen_can_be_rendered()
    {
        $this
            ->actingAs(
                User::factory()->create()
            )
            ->get(route('admin.posts.create'))
            ->assertStatus(200)
        ;
    }

    /** @test */
    public function an_authenticated_user_can_create_posts()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data())
            ->assertSessionHas('success', trans('admin.posts.created'))
            ->assertRedirect(route('admin.posts.index'))
        ;

        $this->assertDatabaseHas('posts', $this->data());
    }

    /** @test */
    public function guests_users_can_not_create_posts()
    {
        $this
            ->post(route('admin.posts.store'), $this->data())
            ->assertRedirect(route('login'))
        ;
    }

    /** @test */
    public function a_created_post_must_have_an_author()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data())
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'user_id' => $user->id,
        ]));
    }

    /** @test */
    public function a_created_post_must_have_a_category()
    {
        // Create additional categories to ensure
        // that the post category is as expected.
        Category::factory(3)->create();

        // $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $category = Category::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'category_id' => $category->id
            ]))
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'user_id'     => $user->id,
            'category_id' => $category->id,
        ]));
    }

    /** @test */
    public function the_slug_of_a_post_should_be_created_automatically()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data())
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'slug' => Str::slug(
                Arr::get($this->data(), 'title')
            ),
        ]));
    }

    /** @test */
    public function a_created_post_must_have_a_unique_slug()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data())
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'slug' => Str::slug(
                Arr::get($this->data(), 'title')
            ),
        ]));

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data())
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'slug' => Str::slug(
                Arr::get($this->data(), 'title')
            ) . '-1',
        ]));
    }

    /*
    |-------------------------------------------------------------------------
    | Title
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function a_post_title_requires_a_minimun_length()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'title' => Str::random(2)
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function the_title_of_a_post_requires_a_maximum_length()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'title' => Str::random(61)
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function a_post_requires_a_title()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'title' => null
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function the_title_of_a_post_must_be_a_string()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'title' => 1234567890
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /*
    |-------------------------------------------------------------------------
    | Body
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function the_body_of_a_post_requires_a_minimum_length()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'body' => Str::random(9)
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    public function a_post_requires_a_body()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'body' => ''
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    public function the_body_of_a_post_must_be_a_string()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'body' => 1234567890
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /*
    |-------------------------------------------------------------------------
    | Description
    |-------------------------------------------------------------------------
    */

    /** @test */
    public function the_description_of_a_post_is_required()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'description' => ''
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_must_be_a_string()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'description' => 1234567890
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_requires_a_minimum_length()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'description' => Str::random(9)
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_requires_a_maximum_length()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), $this->data([
                'description' => Str::random(161)
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    protected function data($overwrite = [])
    {
        return array_merge([
            'title'       => 'Post Title',
            'body'        => 'My first post',
            'description' => 'Lorem ipsum dolor sit, amet consectetur, adipisicing elit.',
        ], $overwrite);
    }
}
