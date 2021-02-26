<?php

namespace Tests\Unit\Models;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Base;
use App\Models\Post;
use App\Models\User;
use Tests\Assertion;
use App\Traits\HasSlug;
use App\Models\Category;
use App\Traits\HasOptions;
use App\Traits\HasPostStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase, Assertion;

    /** @test  */
    public function posts_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('posts', [
                'title',
                'slug',
                'description',
                'body',
                'status',
                'user_id',
                'category_id',
                'options',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
        );
    }

    /** @test */
    public function the_post_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertTrue(is_subclass_of(Post::class, Base::class));
    }

    /** @test */
    public function the_post_model_must_use_the_has_post_status_trait() {
        $this->assertClassUsesTrait(HasPostStatus::class, Post::class);
    }

    /** @test */
    public function the_post_model_must_use_the_has_slug_trait() {
        $this->assertClassUsesTrait(HasSlug::class, Tag::class);
    }

    /** @test */
    public function the_post_model_must_use_the_soft_deletes_trait()
    {
        $this->assertClassUsesTrait(SoftDeletes::class, Post::class);
    }

    /** @test */
    public function the_post_model_must_use_the_has_options_trait()
    {
        $this->assertClassUsesTrait(HasOptions::class, Post::class);
    }

    /** @test */
    public function a_post_morph_many_tags() {
        $post = Post::factory()->hasTags()->create();

        $this->assertInstanceOf(Tag::class, $post->tags->first());
    }

    /** @test */
    public function a_post_belongs_to_a_category()
    {
        // Create additional categories to ensure
        // that the post category is as expected.
        Category::factory()->times(3)->create();

        $category = Category::factory()->create();

        $post = Post::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(Category::class, $post->category);

        $this->assertEquals($category->id, $post->category->id);
    }

    /** @test */
    public function a_post_belongs_to_a_user()
    {
        // Create additional users to ensure
        // that the post user is as expected.
        User::factory()->times(3)->create();

        $user = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $post->user);

        $this->assertEquals($user->id, $post->user->id);
    }

    /** @test */
    public function a_post_can_have_different_statuses()
    {
        $post = Post::factory()->private()->create();

        $this->assertFalse($post->isPublished());
        $this->assertFalse($post->isReview());
        $this->assertTrue($post->isPrivate());

        $post = Post::factory()->published()->create();

        $this->assertTrue($post->isPublished());
        $this->assertFalse($post->isReview());
        $this->assertFalse($post->isPrivate());

        $post = Post::factory()->review()->create();

        $this->assertFalse($post->isPublished());
        $this->assertTrue($post->isReview());
        $this->assertFalse($post->isPrivate());
    }

    /** @test */
    public function the_review_method_should_return_the_posts_under_review()
    {
        $posts = Post::factory()->times(3)->review()->create();

        Post::review()->get()->map(function($post) use ($posts) {
            $this->assertTrue($posts->contains($post->id));
        });
    }

    /** @test */
    public function the_private_method_should_return_the_private_posts()
    {
        $posts = Post::factory()->times(3)->private()->create();

        Post::private()->get()->map(function($post) use ($posts) {
            $this->assertTrue($posts->contains($post->id));
        });
    }

    /** @test */
    public function the_published_method_should_return_the_public_posts()
    {
        $posts = Post::factory()->times(3)->published()->create();

        Post::published()->get()->map(function($post) use ($posts) {
            $this->assertTrue($posts->contains($post->id));
        });
    }

    /** @test */
    public function a_post_can_be_marked_as_published() {
        $post = Post::factory()->review()->create();

        $this->assertTrue($post->isReview());

        $post->markAsPublished();

        $this->assertFalse($post->isReview());
        $this->assertTrue($post->isPublished());
    }

    /** @test */
    public function a_post_can_be_marked_as_private() {
        $post = Post::factory()->review()->create();

        $this->assertTrue($post->isReview());

        $post->markAsPrivate();

        $this->assertFalse($post->isReview());
        $this->assertTrue($post->isPrivate());
    }

    /** @test */
    public function a_post_can_be_marked_as_review() {
        $post = Post::factory()->published()->create();

        $this->assertTrue($post->isPublished());

        $post->markAsReview();

        $this->assertFalse($post->isPublished());
        $this->assertTrue($post->isReview());
    }
}
