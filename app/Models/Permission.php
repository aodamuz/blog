<?php

namespace App\Models;

use App\Traits\ConvertToModels;

class Permission extends Base
{
    use ConvertToModels;

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
