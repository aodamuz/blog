<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Post;
use Tests\Assertion;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, Assertion;

    /** @test */
    public function the_category_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertTrue(is_subclass_of(Category::class, Base::class));
    }

    /** @test */
    public function the_category_model_must_use_the_sluggable_trait()
    {
        $this->assertClassUsesTrait(Sluggable::class, Category::class);
    }

    /** @test */
    public function a_category_has_many_posts()
    {
        // Create additional categories to make sure that
        // the posts belong to the expected category.
        Category::factory()->times(3)->create();

        $category = Category::factory()->create();

        $posts = Post::factory()->times(5)->create([
            'category_id' => $category->id,
        ]);

        $this->assertEquals(
            $posts->pluck('id')->toArray(),
            $category->posts->pluck('id')->toArray()
        );
    }
}
