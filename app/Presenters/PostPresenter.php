<?php

namespace App\Presenters;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Support\Enum\PostStatus;

class PostPresenter extends Presenter
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function tags()
    {
        return Tag::all()->pluck('title', 'id');
    }

    public function categories()
    {
        return Category::all()->pluck('title', 'id');
    }

    public function statuses()
    {
        return PostStatus::all();
    }

    public function defaultStatus()
    {
        return PostStatus::DEFAULT;
    }

    public function selectedStatus($key)
    {
        return old('status', $this->defaultStatus) == $key ? 'selected' : '';
    }
}
