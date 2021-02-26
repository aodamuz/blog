<?php

namespace App\Models;

use App\Traits\HasSlug;

class Permission extends Base
{
	use HasSlug;

	/*
	|--------------------------------------------------------------------------
	| Set Up
	|--------------------------------------------------------------------------
	*/

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/*
	|--------------------------------------------------------------------------
	| Relations
	|--------------------------------------------------------------------------
	*/

	/**
	 * The roles that belong to the permission.
	 */
	public function roles() {
		return $this->belongsToMany(Role::class);
	}
}
