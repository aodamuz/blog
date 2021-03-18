<?php

namespace Tests\Unit\Repositories\Posts;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Http\Request;
use Codeception\AssertThrows;
use Illuminate\Testing\Assert;
use App\Repositories\Posts\Eloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostsTest extends TestCase
{
    use RefreshDatabase, AssertThrows;

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(Eloquent::class);
    }

    /** @test */
    public function paginate()
    {
        $posts = Post::factory()->times(5)->create();

        $posts = $posts->sortByDesc('id')->values();

        $result = $this->repository->paginate(2)->toArray();

        $this->assertEquals(2, count($result['data']));

        $this->assertEquals(5, $result['total']);

        Assert::assertArraySubset($posts[0]->toArray(), $result['data'][0]);

        Assert::assertArraySubset($posts[1]->toArray(), $result['data'][1]);
    }

    /** @test */
    public function find()
    {
        $post = Post::factory()->create();

        $this->assertTrue(
            $post->is($this->repository->find($post->id))
        );

        $this->assertThrows(ModelNotFoundException::class, function() {
            $this->repository->find(2);
        });
    }

    /** @test */
    public function getModel()
    {
        $this->assertEquals(Post::class, get_class($this->repository->getModel()));
    }
}
