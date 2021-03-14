<?php

namespace App\Traits;

use Illuminate\Filesystem\Filesystem;

trait InteractsWithFilesystem
{
    /**
     * Return a fresh instance of Filesystem.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function files()
    {
        return new Filesystem;
    }

    /**
     * Call the files property with magic method.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, 'files') && $property === 'files') {
            return $this->files;
        }

        if ($property === 'files') {
            return $this->files();
        }
    }
}
