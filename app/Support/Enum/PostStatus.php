<?php

namespace App\Support\Enum;

class PostStatus
{
    const PUBLISHED = 'published';
    const HIDDEN = 'hidden';
    const REVIEW = 'review';

    public static function all()
    {
        return [
            self::HIDDEN => __('Private'),
            self::REVIEW => __('Review'),
            self::PUBLISHED => __('Published'),
        ];
    }
}
