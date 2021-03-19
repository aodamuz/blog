<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Models\Post;
use App\Http\Requests\Posts\EditRequest;
use App\Http\Controllers\Admin\Resources\PostController;

class EditTest extends TestCase
{
    /**
     * @test
     */
    public function the_edit_method_uses_edit_request()
    {
        $this->assertActionUsesFormRequest(
            PostController::class,
            'edit',
            EditRequest::class
        );
    }

    /** @test */
    public function the_edit_post_screen_can_be_rendered()
    {
        $user = $this->authorUser();
        $post = Post::factory()->for($user)->create();

        $this
            ->actingAs($user)
            ->get(route('admin.posts.edit', $post))
            ->assertOk()
            ->assertViewIs('admin.posts.create-edit')
            ->assertViewHas(['post', 'categories', 'tags', 'users'])
        ;
    }

    /** @test */
    public function a_user_without_permission_cannot_edit_posts()
    {
        $this->actingAs(
            $this->userWithAccess()
        );

        $this->get(
            route('admin.dashboard')
        )->assertOk();

        $this->get(
            route('admin.posts.edit', Post::factory()->create())
        )->assertForbidden();
    }
}
