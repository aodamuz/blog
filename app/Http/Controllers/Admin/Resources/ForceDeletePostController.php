<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Post;
use App\Support\Response\Messages;
use App\Http\Controllers\Controller;

class ForceDeletePostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Models\Post  $post
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Post $post)
    {
        $this->authorize('forceDelete', $post);

        $post->forceDelete();

        return redirect()
            ->route('admin.posts.index')
            ->withSuccess(__(Messages::POST_PERMANENTLY_DELETED));
    }
}
