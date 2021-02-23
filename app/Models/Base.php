<?php

namespace App\Models;

use App\Traits\HasOptions;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Base extends Model
{
    use Sluggable, Cachable, HasOptions, HasFactory;

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
    protected $guarded = ['id', 'removable'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'option'
    ];

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
