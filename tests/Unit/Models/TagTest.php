<?php

namespace Tests\Unit\Models;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Base;
use App\Models\Post;
use Tests\Assertion;
use App\Traits\HasSlug;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase, Assertion;

    /** @test  */
    public function tags_database_has_expected_columns()
    {
        $this->assertDatabaseHasColumns('tags', [
            'id',
            'title',
            'slug',
            'description',
            'created_at',
            'updated_at',
        ]);
    }

    /** @test  */
    public function taggables_database_has_expected_columns()
    {
        $this->assertDatabaseHasColumns('taggables', [
            'tag_id',
            'taggable_id',
            'taggable_type',
        ]);
    }

    /** @test */
    public function the_tag_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertSubclassOf(Tag::class, Base::class);
    }

    /** @test */
    public function the_tag_model_must_use_the_has_slug_trait() {
        $this->assertClassUsesTrait(HasSlug::class, Tag::class);
    }

    /** @test */
    public function a_tag_morph_many_posts()
    {
        $tag = Tag::factory()->hasPosts()->create();

        $this->assertInstanceOf(Post::class, $tag->posts->first());
    }
}
