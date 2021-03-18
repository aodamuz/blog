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
        return old('status', $this->defaultStatus()) == $key ? 'selected' : '';
    }

    public function statusClass()
    {
        switch ($this->model->status) {
            case PostStatus::REVIEW:
                return 'text-orange-700 bg-orange-100 dark:bg-orange-700 dark:text-orange-100';
                break;

            case PostStatus::HIDDEN:
                return 'text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100';
                break;

            default:
                return 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100';
                break;
        }
    }
}
