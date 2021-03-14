<?php

namespace App\Traits;

use Symfony\Component\Finder\Finder;

trait InteractsWithFinder
{
    /**
     * Finder allows to build rules to find files and directories.
     *
     * @return \Symfony\Component\Finder\Finder
     */
    public function finder()
    {
        return new Finder;
    }

    /**
     * Call the finder property with magic method.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, 'finder') && $property === 'finder') {
            return $this->finder;
        }

        if ($property === 'finder') {
            return $this->finder();
        }
    }
}
