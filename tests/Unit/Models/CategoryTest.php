<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Post;
use App\Traits\HasSlug;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function categories_database_has_expected_columns()
    {
        $this->assertDatabaseHasColumns('categories', [
            'id',
            'title',
            'slug',
            'description',
            'created_at',
            'updated_at',
        ]);
    }

    /** @test */
    public function the_category_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertSubclassOf(Category::class, Base::class);
    }

    /** @test */
    public function the_category_model_must_use_the_has_slug_trait() {
        $this->assertClassUsesTrait(HasSlug::class, Category::class);
    }

    /** @test */
    public function a_category_has_many_posts()
    {
        // Create additional categories to make sure that
        // the posts belong to the expected category.
        Category::factory()->times(3)->create();

        $category = Category::factory()
            ->hasPosts(3)
            ->create();

        $this->assertEquals(
            Post::pluck('id')->toArray(),
            $category->posts->pluck('id')->toArray()
        );
    }
}
