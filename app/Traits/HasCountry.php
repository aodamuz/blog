<?php

namespace App\Traits;

use App\Models\Country;

trait HasCountry
{
    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Relationship with the Country model.
     */
    public function country()
    {
        return $this->belongsTo(
            Country::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Assign the given country to the model.
     *
     * @param string|\App\Models\Country $country
     *
     * @return $this
     */
    public function assignCountry($country)
    {
        if (is_string($country))
            $country = Country::whereSlug($country)->first();

        if (is_integer($country))
            $country = Country::find($country);

        if ($country && $country instanceof Country) {
            $this->country()->associate($country);
        } else {
            throw new \InvalidArgumentException("No country with this name was found.");
        }

        $this->save();

        return $this;
    }

    /**
     * Verify if this user has the given country.
     *
     * @param mixed $countrys
     *
     * @return bool
     */
    public function hasCountry($countrys)
    {
        return collect($countrys)->map(function($country) {
            if ($country instanceof Country) {
                $country = $country->slug;
            }

            return $country;
        })->contains($this->country->slug);
    }
}
