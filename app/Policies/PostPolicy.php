<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission([
            'post-manager',
            'view-posts',
        ]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        return $post->isPublished();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission([
            'post-manager',
            'create-posts',
        ]);
    }

    /**
     * Determine if the user can set the state of the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function setStatus(User $user, Post $post)
    {
        if ($user->hasPermission('post-manager')) {
            return true;
        }

        return $user->hasPermission('set-post-status') && $user->isAuthorOf($post);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        if ($post->trashed()) {
            return false;
        }

        return $user->hasPermission([
            'post-manager',
            'edit-posts',
        ]) || $user->isAuthorOf($post);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        if ($post->trashed()) {
            return false;
        }

        if ($user->hasPermission('post-manager')) {
            return true;
        }

        return $user->hasPermission('delete-posts') && $user->isAuthorOf($post);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        return $user->isAnyAdmin() && $post->trashed();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        return $user->isSuperAdmin();
    }
}
