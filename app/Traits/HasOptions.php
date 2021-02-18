<?php

namespace App\Traits;

use App\Models\Option;

trait HasOptions {
	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get option relationship.
	 */
	public function option() {
		return $this->morphOne(Option::class, 'optionable');
	}
}
