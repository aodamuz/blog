<?php

namespace App\Repositories\Posts;

use Illuminate\Http\Request;

interface Posts
{
    /**
     * Paginate the given query.
     *
     * @param string|int $size
     * @param string|null $search
     * @param string|null $status
     * @param string $sort
     * @param string $direction
     * @param string|null $trashed
     * @param array $appends
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate(
        $size = 15,
        string $search = null,
        string $status = null,
        string $sort = 'id',
        string $direction = 'desc',
        string $trashed = null,
        array $appends = []
    );

    /**
     * Update a post in the database.
     *
     * @param int|string $identifier
     * @param array $attributes
     *
     * @return \App\Models\Post
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($identifier, array $attributes);

    /**
     * Delete a post from the database.
     *
     * @param int|string $identifier
     *
     * @return bool|null
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete($identifier);

    /**
     * Find a post by its primary key.
     *
     * @param int|string $identifier
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($identifier);
}
