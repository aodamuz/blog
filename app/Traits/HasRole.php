<?php

namespace App\Traits;

use App\Models\Role;

trait HasRole
{
    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Relationship with the Role model.
     */
    public function role()
    {
        return $this->belongsTo(
            Role::class
        );
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
    public function assignRole($role)
    {
        if (is_string($role))
            $role = Role::whereSlug($role)->first();

        if (is_integer($role))
            $role = Role::find($role);

        if ($role && $role instanceof Role) {
            $this->role()->associate($role);
        } else {
            throw new \InvalidArgumentException("No role with this name was found.");
        }

        $this->save();

        return $this;
    }

    /**
     * Assign the permissions given to the model.
     *
     * @param array|string|\App\Models\Permission $permissions
     *
     * @return $this
     */
    public function assignPermissions($permissions)
    {
        $this->role->assignPermissions($permissions);

        return $this->fresh();
    }

    /**
     * Remove permissions granted.
     *
     * @param array|string|\App\Models\Permission $permissions
     *
     * @return $this
     */
    public function removePermissions($permissions)
    {
        $this->role->removePermissions($permissions);

        return $this->fresh();
    }

    /**
     * Verify if this user has the given role.
     *
     * @param mixed $roles
     *
     * @return bool
     */
    public function hasRole($roles)
    {
        return collect($roles)->map(function($role) {
            if ($role instanceof Role) {
                $role = $role->slug;
            }

            return $role;
        })->contains($this->role->slug);
    }

    /**
     * Check if the given user can access the admin panel.
     *
     * @return bool
     */
    public function canAccess()
    {
        return $this->hasPermission(config('permissions.access_key'));
    }

    /**
     * Check if this user has the given permissions.
     *
     * @param mixed $permissions
     *
     * @return bool
     */
    public function hasPermission($permissions)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->role->permissions->pluck('slug')
            ->intersect($permissions)
            ->isNotEmpty()
        ;
    }

    /**
     * Verify if the user is any of the administrators.
     *
     * @return bool
     */
    public function isAnyAdmin()
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    /**
     * Verify if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Verify if the user is a global administrator.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('global');
    }
}
