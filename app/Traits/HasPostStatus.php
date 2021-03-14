<?php

namespace App\Traits;

use App\Support\Enum\PostStatus;

trait HasPostStatus
{
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
    public function scopeHidden($query)
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

    /**
     * Mark post as published.
     *
     * @return bool
     */
    public function markAsPublished()
    {
        return $this->update([
            'status' => PostStatus::PUBLISHED,
        ]);
    }

    /**
     * Mark post as private.
     *
     * @return bool
     */
    public function markAsPrivate()
    {
        return $this->update([
            'status' => PostStatus::HIDDEN,
        ]);
    }

    /**
     * Mark post as review.
     *
     * @return bool
     */
    public function markAsReview()
    {
        return $this->update([
            'status' => PostStatus::REVIEW,
        ]);
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
