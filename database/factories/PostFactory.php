<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'        => $this->faker->name,
            'body'         => $this->faker->text(),
            'description'  => $this->faker->text(155),
            'user_id'      => User::factory()->create(),
            'category_id'  => Category::factory()->create(),
            'published_at' => now(),
        ];
    }
}
