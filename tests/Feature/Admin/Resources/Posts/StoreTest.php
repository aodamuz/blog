<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Support\Enum\PostStatus;
use Database\Seeders\RoleSeeder;
use App\Support\Response\Messages;
use Database\Seeders\CategorySeeder;
use App\Http\Requests\Posts\StoreRequest;
use App\Http\Controllers\Admin\Resources\PostController;

class StoreTest extends TestCase
{
    /**
     * @test
     */
    public function the_store_method_uses_store_request(): void
    {
        $this->assertActionUsesFormRequest(
            PostController::class,
            'store',
            StoreRequest::class
        );
    }

    /** @test */
    public function a_user_with_permissions_can_store_posts()
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
    public function a_user_without_permissions_cannot_store_posts()
    {
        $this->actingAs(
            $this->userWithAccess()
        );

        $this->get(
            route('admin.dashboard')
        )->assertOk();

        $this
            ->post(route('admin.posts.store'), $this->data())
            ->assertForbidden()
        ;

        $this->assertDatabaseMissing('posts', $this->data());
    }

    /** @test */
    public function a_stored_post_must_have_an_author()
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
    public function a_stored_post_can_have_a_category()
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
        $this->assertEquals($category->getRouteKey(), Post::first()->category->getRouteKey());
    }

    /** @test */
    public function a_stored_post_may_not_have_a_category()
    {
        $this->seed(CategorySeeder::class);

        $this
            ->actingAs($this->authorUser())
            ->post(route('admin.posts.store'), $this->data())
        ;

        $this->assertInstanceOf(Category::class, Post::first()->category);
        $this->assertEquals(1, Post::first()->category->getRouteKey());
    }

    /** @test */
    public function a_stored_post_can_have_many_tags()
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
            $this->assertTrue($tags->pluck('id')->contains($tag->getRouteKey()));
        });
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
