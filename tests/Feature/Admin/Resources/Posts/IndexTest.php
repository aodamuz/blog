<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;
use App\Http\Requests\Posts\IndexRequest;
use App\Http\Controllers\Admin\Resources\PostController;

class IndexTest extends TestCase
{
    /**
     * @test
     */
    public function the_index_method_uses_index_request(): void
    {
        $this->assertActionUsesFormRequest(
            PostController::class,
            'index',
            IndexRequest::class
        );
    }

    /** @test */
    public function the_screen_to_see_the_list_of_posts_can_be_rendered()
    {
        Post::factory(3)->create();

        $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index'))
            ->assertOk()
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts');
        ;
    }

    /** @test */
    public function a_search_can_find_a_post_by_its_title()
    {
        Post::factory(3)->create();

        $post = Post::factory()->create(['title' => 'Testing the search']);

        Post::factory(3)->create();

        $response = $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index', ['search' => 'testing']))
        ;

        $this->assertCount(1, $response['posts']);

        $this->assertEquals($post->getRouteKey(), $response['posts']->first()->getRouteKey());
    }

    /** @test */
    public function posts_can_be_filtered_by_status()
    {
        Post::factory(3)->review()->create();

        $posts = Post::factory(3)->hidden()->create();

        Post::factory(3)->review()->create();

        $response = $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index', ['status' => 'hidden']))
        ;

        $this->assertCount(3, $response['posts']);

        $posts->map(function($post) use ($response) {
            $this->assertTrue($response['posts']->contains($post->getRouteKey()));
        });
    }

    /** @test */
    public function posts_can_be_sorted_by_title_asc()
    {
        Post::factory()->create(['title' => 'Title C']);
        Post::factory()->create(['title' => 'Title A']);
        Post::factory()->create(['title' => 'Title B']);

        $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index', [
                'sort' => 'title',
                'direction' => 'asc',
            ]))
            ->assertSeeInOrder([
                'Title A',
                'Title B',
                'Title C',
            ])
        ;
    }

    /** @test */
    public function posts_can_be_sorted_by_title_desc()
    {
        Post::factory()->create(['title' => 'Title A']);
        Post::factory()->create(['title' => 'Title C']);
        Post::factory()->create(['title' => 'Title B']);

        $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index', [
                'sort' => 'title',
                'direction' => 'desc',
            ]))
            ->assertSeeInOrder([
                'Title C',
                'Title B',
                'Title A',
            ])
        ;
    }

    /** @test */
    public function all_posts_should_be_displayed_except_the_ones_in_the_trash()
    {
        Post::factory(3)->create();
        Post::factory(3)->trashed()->create();

        $response = $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index'))
        ;

        $this->assertCount(3, $response['posts']);

        $response['posts']->map(function($post) {
            $this->assertFalse($post->trashed());
        });
    }

    /** @test */
    public function only_posts_that_are_in_the_trash_should_be_displayed()
    {
        Post::factory(3)->create();
        Post::factory(3)->trashed()->create();

        $response = $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index', ['trashed' => 'only']))
        ;

        $this->assertCount(3, $response['posts']);

        $response['posts']->map(function($post) {
            $this->assertTrue($post->trashed());
        });
    }

    /** @test */
    public function all_posts_can_be_displayed_even_in_the_trash_can()
    {
        Post::factory(3)->create();

        Post::factory(3)->trashed()->create();

        $response = $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.index', [
                'trashed' => 'with',
            ]))
        ;

        $this->assertCount(6, $response['posts']);
    }
}
