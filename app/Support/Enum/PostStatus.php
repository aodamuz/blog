<?php

namespace App\Support\Enum;

class PostStatus
{
    const PUBLISHED = 'published';
    const HIDDEN = 'hidden';
    const REVIEW = 'review';
    const DEFAULT = 'review';

    public static function keys()
    {
        return array_keys(self::all());
    }

    public static function all()
    {
        return [
            self::HIDDEN => __('Private'),
            self::REVIEW => __('Review'),
            self::PUBLISHED => __('Published'),
        ];
    }
}
