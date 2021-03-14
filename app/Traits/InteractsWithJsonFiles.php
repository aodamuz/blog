<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

trait InteractsWithJsonFiles
{
    /**
     * Read a json file and convert it to Collection.
     *
     * @param string $path
     * @param bool $collection
     *
     * @throws \InvalidArgumentException
     * @return Illuminate\Support\Collection
     */
    public function readJson(string $path, bool $collection = true)
    {
        $contents = [];

        if (Str::startsWith($path, ['http://', 'https://'])) {
            $contents = json_decode(
                file_get_contents($path)
            , true);
        } else {
            if (!is_dir($dir = dirname($path)))
                if (is_dir(dirname($dir)))
                    mkdir(dirname($path), 0755, true);

            if (file_exists($path)) {
                $contents = json_decode(
                    file_get_contents($path)
                , true);

                if (is_null($contents) || json_last_error() !== JSON_ERROR_NONE)
                    throw new \InvalidArgumentException('Invalid JSON in ' . $path);
            }
        }

        if (!$collection) {
            return $contents;
        }

        return new Collection($contents);
    }

    /**
     * Save a json file with array information.
     *
     * @param string $path
     * @param array $data
     * @param bool $sort
     *
     * @throws \RuntimeException
     * @return bool
     */
    public function storeJson(string $path, array $data, bool $sort = false)
    {
        if ($data instanceof Collection)
            $data = $data->toArray();

        if (!is_array($data))
            throw new \RuntimeException("Invalid data for json.");

        if ($sort)
            $data = Arr::sortRecursive($data);

        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

        return (bool) file_put_contents($path, $data, 0);
    }
}
