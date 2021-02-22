<?php

namespace App\Observers;

use App\Traits\HasOptions;

abstract class Observer
{
    /**
     * Handle the model "created" event.
     *
     * @param  Object $model
     * @return void
     */
    public function created($model)
    {
        if (in_array(HasOptions::class, trait_uses_recursive($model))) {
    	   $model->option()->create(['items' => []]);
        }
    }
}
