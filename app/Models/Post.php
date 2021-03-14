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

    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tags relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Category relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |-------------------------------------------------------------------------
    | Mutators & Accesors
    |-------------------------------------------------------------------------
    */

    /**
     * Set the post's category_id.
     *
     * @param  int $value
     *
     * @return void
     */
    public function setCategoryIdAttribute($value)
    {
        // If a category is not selected, we will
        // force the model to set category 1.
        $this->attributes['category_id'] = $value ?? 1;
    }

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

    /**
     * Present the logic in the views.
     *
     * @return \App\Presenters\PostPresenter
     */
    public function present()
    {
        return new PostPresenter($this);
    }
}
