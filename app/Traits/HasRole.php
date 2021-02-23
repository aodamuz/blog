<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

trait HasRole {
	/*
	|--------------------------------------------------------------------------
	| Relations
	|--------------------------------------------------------------------------
	*/

	/**
	 * Relationship with the Role model.
	 */
	public function role() {
		return $this->belongsTo(
			Role::class
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Mutators
	|--------------------------------------------------------------------------
	*/

	/**
	 * Set a role to this user only if this user is not the authenticated user.
	 *
	 * @param int|string
	 *
	 * @return void
	 */
	public function setRoleIdAttribute($value) {
		if ( auth()->check() && auth()->id() === $this->id ) {
			return;
		}

		$this->attributes['role_id'] = $value;
	}

	/*
	|--------------------------------------------------------------------------
	| Helpers
	|--------------------------------------------------------------------------
	*/

	/**
	 * Assign the given role to the model.
	 *
	 * @param string|\App\Models\Role $role
	 *
	 * @return $this
	 */
	public function assignRole($role) {
		if (is_string($role)) {
			$role = Role::whereSlug($role)->first();
		}

		if (is_integer($role)) {
			$role = Role::find($role);
		}

		if ($role && $role instanceof Role) {
			$this->role_id = $role->id;
			$this->save();
		} else {
			throw new \InvalidArgumentException("No role with this name was found.");
		}

		return $this;
	}

	/**
	 * Verify if this user has the given role.
	 *
	 * @param mixed $roles
	 *
	 * @return boolean
	 */
	public function hasRole($roles) {
		return collect($roles)->contains($this->role->slug);
	}

	/**
	 * Check if this user has the given permissions.
	 *
	 * @param mixed $permissions
	 *
	 * @return boolean
	 */
	public function hasPermission($permissions) {
		if ($this->isSuperAdmin()) {
			return true;
		}

		return $this->role->permissions->pluck('slug')
			->intersect($permissions)
			->isNotEmpty()
		;
	}

	/**
	 * Verify if the user is an administrator.
	 *
	 * @return boolean
	 */
	public function isAdmin() {
		return $this->hasRole('admin');
	}

	/**
	 * Verify if the user is a global administrator.
	 *
	 * @return boolean
	 */
	public function isSuperAdmin() {
		return $this->hasRole('global');
	}

	/**
	 * Verify if the user is any of the administrators.
	 *
	 * @return boolean
	 */
	public function isAnyAdmin() {
		return $this->hasRole(['admin', 'global']);
	}
}
