<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Role;
use App\Models\Category;
use App\Repositories\Posts\Posts;
use App\Support\Response\Messages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\EditRequest;
use App\Http\Requests\Posts\IndexRequest;
use App\Http\Requests\Posts\StoreRequest;
use App\Http\Requests\Posts\CreateRequest;
use App\Http\Requests\Posts\UpdateRequest;
use App\Http\Requests\Posts\DestroyRequest;

class PostController extends Controller
{
    /**
     * Resource repository.
     *
     * @var \App\Repositories\Posts\Posts
     */
    protected $repository;

    /**
     * Store the controller instance.
     *
     * @return void
     */
    public function __construct(Posts $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Posts\IndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $posts = $this->repository->paginate(
            $request->get('size', 25),
            $request->get('search'),
            $request->get('status'),
            $request->get('sort', 'id'),
            $request->get('direction', 'desc'),
            $request->get('trashed'),
            $request->query()
        );

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\Posts\CreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request)
    {
        $users = Role::authors()->pluck('name', 'id');
        $categories = Category::pluck('title', 'id');
        $tags = Tag::pluck('title', 'id');
        $post = $this->repository->getModel();

        return view('admin.posts.create-edit', compact('post', 'users', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Posts\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $request
            ->user()
            ->posts()
            ->create(
                $request->validated()
            )
            ->tags()->attach(
                $request->tags ?? []
            )
        ;

        return redirect()
            ->route('admin.posts.index')
            ->withSuccess(__(Messages::POST_CREATED));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Requests\Posts\EditRequest $request
     * @param  int|string $identifier
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(EditRequest $request, $identifier)
    {
        $post = $this->repository->find($identifier);
        $users = Role::authors()->pluck('name', 'id');
        $categories = Category::pluck('title', 'id');
        $tags = Tag::pluck('title', 'id');

        return view('admin.posts.create-edit', compact('post', 'users', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Posts\UpdateRequest  $request
     * @param  int|string $identifier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $identifier)
    {
        $this->repository->update($identifier, $request->validated());

        return redirect()
            ->route('admin.posts.edit', $identifier)
            ->withSuccess(__(Messages::POST_UPDATED));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Posts\DestroyRequest  $request
     * @param  int|string $identifier
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $identifier)
    {
        $this->repository->delete($identifier);

        return redirect()->route('admin.posts.index')->withSuccess(
            __(Messages::POST_DELETED)
        );
    }
}
