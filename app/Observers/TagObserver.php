<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver
{
    /**
     * Handle the model "deleting" event.
     *
     * @param  \App\Models\Tag $model
     *
     * @return void
     */
    public function deleting(Tag $model)
    {

        $model->posts()->detach();
    }
}
