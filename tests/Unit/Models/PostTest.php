<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Post;
use Tests\Assertion;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase {
	use RefreshDatabase, Assertion;

	/** @test */
	public function the_post_model_must_be_a_subclass_of_the_base_model() {
		$this->assertTrue(is_subclass_of(Post::class, Base::class));
	}

	/** @test */
	public function the_post_model_must_use_the_sluggable_trait() {
		$this->assertClassUsesTrait(Sluggable::class, Post::class);
	}

	// /** @test */
	// public function a_post_belongs_to_a_category() {
	// 	$category = Category::factory()->create();

	// 	$post = Post::factory()->create([
	// 		'category_id' => $category->id,
	// 	]);

	// 	$this->assertInstanceOf(Category::class, $post->category);
	// }
}
