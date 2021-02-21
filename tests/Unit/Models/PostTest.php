<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Post;
use App\Models\User;
use Tests\Assertion;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase, Assertion;

    /** @test */
    public function the_post_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertTrue(is_subclass_of(Post::class, Base::class));
    }

    /** @test */
    public function the_post_model_must_use_the_sluggable_trait()
    {
        $this->assertClassUsesTrait(Sluggable::class, Post::class);
    }

    /** @test */
    public function a_post_belongs_to_a_category()
    {
        $category = Category::factory()->create();

        $post = Post::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertInstanceOf(Category::class, $post->category);

        $this->assertEquals(Category::first()->id, $post->category->id);
    }

    /** @test */
    public function a_post_belongs_to_a_user()
    {
        $user = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $post->user);

        $this->assertEquals(User::first()->id, $post->user->id);
    }

    /** @test */
    public function a_post_can_be_public_or_private()
    {
        $post = Post::factory()->create([
            'published_at' => null,
        ]);

        $this->assertFalse($post->isItPublic());

        $post = Post::factory()->create();

        $this->assertTrue($post->isItPublic());
    }

    /** @test */
    public function private_posts_cannot_be_displayed()
    {
        $privates = Post::factory(3)->create([
            'published_at' => null,
        ]);

        $published = Post::factory(3)->create();

        $all = Post::published()->get();

        foreach ($privates->pluck('id') as $id) {
            $this->assertFalse($all->contains($id));
        }

        foreach ($published->pluck('id') as $id) {
            $this->assertTrue($all->contains($id));
        }
    }
}
