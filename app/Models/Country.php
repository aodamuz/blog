<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasOptions;

class Country extends Base
{
    use HasSlug, HasOptions;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
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
}
