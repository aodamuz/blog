<?php

namespace App\Models;

use App\Traits\ConvertToModels;

class Role extends Base
{
    use ConvertToModels;

    /*
    |--------------------------------------------------------------------------
    | Set Up
    |--------------------------------------------------------------------------
    */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'removable' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'permissions'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Relationship with the User model.
     */
    public function users()
    {
        return $this->hasMany(
            User::class
        );
    }

    /**
     * The permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    /**
     * Assign permissions to a role.
     *
     * @param array|string|\App\Models\Permission $permission
     *
     * @return $this
     */
    public function assignPermissions($permissions)
    {
        $this->permissions()->sync(
            $this->convertToModels($permissions, new Permission)
                ->map(function($permission) {
                    return $permission->id;
                })
                ->all()
        );

        return $this;
    }
}
