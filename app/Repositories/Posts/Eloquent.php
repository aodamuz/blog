<?php

namespace App\Repositories\Posts;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Repositories\Repository;

class Eloquent extends Repository implements Posts
{
    /**
     * Create a new eloquent repository instance.
     *
     * @param \App\Models\Post $model
     *
     * @return void
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

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
    ) {
        $query = $this->model->query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', "like", "%{$search}%");
                $q->orWhere('slug', 'like', "%{$search}%");
                $q->orWhere('body', 'like', "%{$search}%");
                $q->orWhere('description', 'like', "%{$search}%");
            });
        }

        switch ($trashed) {
            case 'only':
                $query->onlyTrashed();
                break;

            case 'with':
                $query->withTrashed();
                break;
        }

        return $query->orderBy(
            $sort,
            $direction
        )->paginate(
            $size
        )->onEachSide(2)->appends($appends);
    }

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
    public function update($identifier, array $attributes)
    {
        $post = $this->find($identifier);

        $post->update($attributes);

        return $post;
    }

    /**
     * Delete a post from the database.
     *
     * @param int|string $identifier
     *
     * @return bool|null
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete($identifier)
    {
        return $this->find($identifier)->delete();
    }

    /**
     * Find a post by its primary key.
     *
     * @param int|string $identifier
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($identifier)
    {
        return $this->model->findOrFail($identifier);
    }
}
