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

class CreatePostTest extends TestCase
{
    /** @test */
    public function the_screen_for_creating_posts_can_be_rendered()
    {
        $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.create'))
            ->assertOk()
            ->assertViewIs('admin.posts.create-edit')
        ;
    }

    /** @test */
    public function a_user_without_permission_cannot_create_posts() {
        $user = $this->user()->assignPermissions('access');

        $this->actingAs($user)->get(
            route('admin.posts.create')
        )->assertForbidden();
    }

    /** @test */
    public function a_user_with_permissions_can_create_posts()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data())
            ->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('success', __(Messages::POST_CREATED))
        ;

        $this->assertDatabaseHas('posts', $this->data());
    }

    /** @test */
    public function the_slug_of_a_post_should_be_created_automatically()
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
    public function a_created_post_must_have_a_unique_slug()
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

        $this->post(route('admin.posts.store'), $this->data());

        $this->assertDatabaseHas('posts', $this->data([
            'slug' => Str::slug(
                Arr::get($this->data(), 'title')
            ) . '-1',
        ]));
    }

    /** @test */
    public function a_created_post_must_have_an_author()
    {
        $this
            ->actingAs($user = $this->authorUser())
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

        $category = Category::factory()->create();

        $this
            ->actingAs($user = $this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'category_id' => $category->id
            ]))
        ;

        $this->assertDatabaseHas('posts', $this->data([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]));

        $this->assertInstanceOf(Category::class, Post::first()->category);
    }

    /** @test */
    public function a_created_post_can_have_many_tags()
    {
        // Create additional categories to ensure
        // that the post category is as expected.
        Tag::factory(3)->create();

        $tags = Tag::factory(3)->create();

        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'tags' => $tags->pluck('id')->toArray(),
            ]))
        ;

        Post::first()->tags->map(function($tag) use ($tags) {
            $this->assertTrue($tags->pluck('id')->contains($tag->id));
        });
    }

    /** @test */
    public function a_post_title_requires_a_minimun_length()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => Str::random(2)
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function the_title_of_a_post_requires_a_maximum_length()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => Str::random(61)
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function a_post_requires_a_title()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => null
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function the_title_of_a_post_must_be_a_string()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'title' => 1234567890
            ]))
            ->assertSessionHasErrors('title')
        ;
    }

    /** @test */
    public function the_body_of_a_post_requires_a_minimum_length()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'body' => Str::random(9)
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    public function a_post_requires_a_body()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'body' => ''
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    public function the_body_of_a_post_must_be_a_string()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'body' => 1234567890
            ]))
            ->assertSessionHasErrors('body')
        ;
    }

    /** @test */
    public function the_description_of_a_post_is_required()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => ''
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_must_be_a_string()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => 1234567890
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_requires_a_minimum_length()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => Str::random(9)
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /** @test */
    public function the_description_of_a_post_requires_a_maximum_length()
    {
        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data([
                'description' => Str::random(161)
            ]))
            ->assertSessionHasErrors('description')
        ;
    }

    /**
     * A post will be created with the default status if
     * the current user is not a post manager.
     *
     * @test
     */
    public function dynamic_status() {
        $this->seed(RoleSeeder::class);

        $author = User::factory()->create()->assignRole('author');
        $admin = User::factory()->create()->assignRole('admin');

        $this
            ->actingAs($author)
            ->post(route('admin.posts.store'), $this->data([
                'status' => PostStatus::PUBLISHED
            ]))
            ->assertSessionHasErrors('status')
        ;

        $this
            ->actingAs($admin)
            ->post(route('admin.posts.store'), $this->data([
                'status' => PostStatus::PUBLISHED
            ]))
            ->assertSessionHasNoErrors('status')
        ;
    }
}
