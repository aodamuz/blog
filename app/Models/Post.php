<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Base {
	use Sluggable;

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable(): array {
		return [
			'slug' => [
				'source' => 'title'
			]
		];
	}
}
