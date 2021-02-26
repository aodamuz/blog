<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ConvertToModels
{
    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Find a result from the identifier, attribute or a model instance.
     *
     * @param mixed $value
     *
     * @return \Illuminate\Support\Collection
     */
    protected function convertToModels(
        $values,
        Model $model,
        string $attribute = 'slug'
    ) {
        if ($values instanceof Collection) {
            $values = $values->all();
        }

        return (new Collection($values))
            ->map(function($value) use ($model, $attribute) {
                if (is_string($value)) {
                    $value = $model->where($attribute, $value)->first();
                }

                if (is_numeric($value)) {
                    $value = $model->find($value);
                }

                if ($value && $value instanceof Model) {
                    return $value;
                }
            })->filter();
    }
}
