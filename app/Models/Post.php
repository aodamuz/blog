<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Support\Enum\PostStatus;

class Post extends Base
{
    use HasSlug;

    /*
    |-------------------------------------------------------------------------
    | Query Scopes
    |-------------------------------------------------------------------------
    */

    /**
     * Scope a query to include only published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED);
    }

    /**
     * Scope a query to include only private posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrivate($query)
    {
        return $query->where('status', PostStatus::HIDDEN);
    }

    /**
     * Scope a query to include only review posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReview($query)
    {
        return $query->where('status', PostStatus::REVIEW);
    }

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

    /**
     * Mark post as published.
     *
     * @return bool
     */
    public function markAsPublished()
    {
        return $this->forceFill([
            'status' => PostStatus::PUBLISHED,
        ])->save();
    }

    /**
     * Mark post as private.
     *
     * @return bool
     */
    public function markAsPrivate()
    {
        return $this->forceFill([
            'status' => PostStatus::HIDDEN,
        ])->save();
    }

    /**
     * Mark post as review.
     *
     * @return bool
     */
    public function markAsReview()
    {
        return $this->forceFill([
            'status' => PostStatus::REVIEW,
        ])->save();
    }

    /**
     * Check if the given post is published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->status === PostStatus::PUBLISHED;
    }

    /**
     * Check if the given post is private.
     *
     * @return bool
     */
    public function isPrivate()
    {
        return $this->status === PostStatus::HIDDEN;
    }

    /**
     * Check if the given post is under review.
     *
     * @return bool
     */
    public function isReview()
    {
        return $this->status === PostStatus::REVIEW;
    }
}
