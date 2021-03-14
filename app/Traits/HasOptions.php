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
}
