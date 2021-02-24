<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

trait HasOptions
{
    /**
     * Get the specified item value.
     *
     * @param  null|string $key
     * @param  mixed       $default
     *
     * @return mixed
     */
    public function get(string $key = null, $default = null)
    {
        $this->makeSureTheOptionsAreArray();

        $options = Arr::wrap($this->options);

        if (empty($key))
            return $options;

        return Arr::get($options, $key, $default);
    }

    /**
     * Set a given item value.
     *
     * @param string|array $key
     * @param mixed        $value
     *
     * @return $this
     */
    public function set($key, $value = null)
    {
        $this->makeSureTheOptionsAreArray();

        $keys = is_array($key) ? $key : [$key => $value];

        if (!empty($keys)) {
            $options = $this->get();

            foreach (Arr::dot($keys) as $key => $value) {
                Arr::set($options, $key, $value);
            }

            $this->update(compact('options'));
        }

        return $this;
    }

    /**
     * Remove an item from the options.
     *
     * @param mixed $key
     *
     * @return $this
     */
    public function forget($key)
    {
        $this->makeSureTheOptionsAreArray();

        if (!empty($key)) {
            if ($key === '*') {
                $this->options = [];
            } else {
                $options = $this->get();

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
    public function flush()
    {
        $this->makeSureTheOptionsAreArray();

        return $this->forget('*');
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
