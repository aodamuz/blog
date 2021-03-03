<?php

namespace App\Models;

use App\Traits\HasRole;
use App\Traits\HasCountry;
use App\Traits\HasOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRole,
        Cachable,
        HasCountry,
        HasFactory,
        HasOptions,
        Notifiable,
        SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'role_id',
        'password',
        'remember_token',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'role'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'email_verified_at' => 'datetime',
    ];

    /*
    |-------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------
    */

    /**
     * Get all of the posts that are assigned this user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /*
    |-------------------------------------------------------------------------
    | Accessors & Mutators
    |-------------------------------------------------------------------------
    */

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->option('first_name')} {$this->option('last_name')}";
    }
}
