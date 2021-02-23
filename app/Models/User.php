<?php

namespace App\Models;

use App\Traits\HasRole;
use App\Traits\HasOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Cachable, HasRole, HasOptions, HasFactory, SoftDeletes, Notifiable;

    /*
    |-------------------------------------------------------------------------
    | Set Up
    |-------------------------------------------------------------------------
    */

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
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'role',
        'option',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    /*
    |-------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------
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
        $o = $this->option;

        return "{$o->get('first_name')} {$o->get('last_name')}";
    }
}
