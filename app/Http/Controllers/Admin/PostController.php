<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Support\Enum\PostStatus;
use App\Support\Response\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\CreateRequest;

class PostController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses      = PostStatus::all();
        $defaultStatus = PostStatus::DEFAULT;
        $tags          = Tag::all()->pluck('title', 'id');
        $categories    = Category::all()->pluck('title', 'id');

        return view('admin.posts.create', compact(
            'statuses', 'defaultStatus', 'tags', 'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Posts\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        Post::create(
            $request->getValidData()
        );

        return redirect()
            ->route('admin.posts.index')
            ->withSuccess(__(Messages::POST_CREATED));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $statuses      = PostStatus::all();
        $defaultStatus = PostStatus::DEFAULT;
        $tags          = Tag::all()->pluck('title', 'id');
        $categories    = Category::all()->pluck('title', 'id');

        return view('admin.posts.edit', compact(
            'post', 'statuses', 'defaultStatus', 'tags', 'categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
