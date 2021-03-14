<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the model "deleting" event.
     *
     * @param  \App\Models\Post $model
     *
     * @return void
     */
    public function deleting(Post $model)
    {

        $model->tags()->detach();
    }
}
