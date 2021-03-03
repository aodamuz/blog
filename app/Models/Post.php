<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasOptions;
use App\Traits\HasPostStatus;
use App\Presenters\PostPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Base
{
    use HasSlug, HasOptions, HasPostStatus, SoftDeletes;

    /*
    |-------------------------------------------------------------------------
    | Set Up
    |-------------------------------------------------------------------------
    */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    /*
    |-------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    public function present()
    {
        return new PostPresenter($this);
    }
}
