<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Option extends Model
{
    use Cachable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'optionable_type',
        'optionable_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array',
    ];

    /*
    |-------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------
    */

    /**
     * Get the optionable entity that the option belongs to.
     */
    public function optionable()
    {
        return $this->morphTo();
    }

    /*
    |-------------------------------------------------------------------------
    | Helpers
    |-------------------------------------------------------------------------
    */

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
        $items = Arr::wrap($this->items);

        if (empty($key))
            return $items;

        return Arr::get($items, $key, $default);
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
        $keys = is_array($key) ? $key : [$key => $value];

        if (!empty($keys)) {
            $items = $this->get();

            foreach (Arr::dot($keys) as $key => $value) {
                Arr::set($items, $key, $value);
            }

            $this->update(compact('items'));
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
        if (!empty($key)) {
            if ($key === '*') {
                $this->items = [];
            } else {
                $items = $this->get();

                Arr::forget($items, $key);

                $this->items = $items;
            }

            $this->save();
        }

        return $this;
    }

    /**
     * Remove all items from the options.
     *
     * @return $this
     */
    public function flush()
    {
        return $this->forget('*');
    }
}
