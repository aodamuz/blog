<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use App\Support\Enum\PostStatus;
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
            'title'       => $this->faker->sentence(4),
            'body'        => $this->faker->text,
            'description' => $this->faker->text(155),
            'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'created_at'  => $this->faker->dateTime(),
            'updated_at'  => $this->faker->dateTime(),
            'status'      => $this->faker->randomElement([
                PostStatus::REVIEW,
                PostStatus::HIDDEN,
                PostStatus::PUBLISHED,
            ]),
        ];
    }

    /**
     * Mark the post as trashed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function trashed()
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => now(),
            ];
        });
    }

    /**
     * Indicate that the post is private.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function hidden()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatus::HIDDEN,
            ];
        });
    }

    /**
     * Indicate that the post is published.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatus::PUBLISHED,
            ];
        });
    }

    /**
     * Indicates that the publication is under review.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function review()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PostStatus::REVIEW,
            ];
        });
    }
}
