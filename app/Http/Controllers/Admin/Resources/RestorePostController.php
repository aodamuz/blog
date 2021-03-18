<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Post;
use App\Support\Response\Messages;
use App\Http\Controllers\Controller;

class RestorePostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  mixed $post
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        $this->authorize('restore', $post);

        $post->restore();

        return redirect()
            ->route('admin.posts.index')
            ->withSuccess(__(Messages::POST_RESTORED));
    }
}
