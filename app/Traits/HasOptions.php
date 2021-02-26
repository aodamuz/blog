<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

trait HasOptions
{
    /**
     * Get one or all of the options or set a new one.
     *
     * @param  null|array|string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    public function option($key = null, $default = null)
    {
        $this->makeSureTheOptionsAreArray();

        $options = Arr::wrap($this->options);

        if (is_array($key)) {
            if (!empty($key)) {
                foreach (Arr::dot($key) as $k => $v) {
                    Arr::set($options, $k, $v);
                }

                $this->update(compact('options'));
            }

            return $this;
        }

        if (empty($key))
            return $options;

        return Arr::get($options, $key, $default);
    }

    /**
     * Remove an item from the options.
     *
     * @param string|array $key
     *
     * @return $this
     */
    public function forgetOption($key)
    {
        if ((is_array($key) || is_string($key)) && !empty($key)) {
            $this->makeSureTheOptionsAreArray();

            if ($key === '*') {
                $this->options = [];
            } else {
                $options = $this->option();

                Arr::forget($options, $key);

                $this->options = $options;
            }

            $this->save();
        }

        return $this;
    }

    /**
     * Remove all options from the options.
     *
     * @return $this
     */
    public function flushOptions()
    {
        return $this->forgetOption('*');
    }

    public function makeSureTheOptionsAreArray()
    {
        if (
            !isset($this->casts['options']) ||
            $this->casts['options'] !== 'array'
        ) {
            throw new InvalidArgumentException(
                'The options attribute must be converted to an array.'
            );
        }

        if (!Schema::hasColumns($this->getTable(), ['options'])) {
            $model = get_class($this);

            throw new InvalidArgumentException(
                "The {$model} model does not have a column named options."
            );
        }
    }
}
