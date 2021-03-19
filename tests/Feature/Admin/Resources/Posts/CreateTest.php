<?php

namespace Tests\Feature\Admin\Resources\Posts;

use App\Http\Requests\Posts\CreateRequest;
use App\Http\Controllers\Admin\Resources\PostController;

class CreateTest extends TestCase
{
    /**
     * @test
     */
    public function the_create_method_uses_create_request()
    {
        $this->assertActionUsesFormRequest(
            PostController::class,
            'create',
            CreateRequest::class
        );
    }

    /** @test */
    public function the_screen_for_creating_posts_can_be_rendered()
    {
        $this
            ->actingAs(
                $this->authorUser()
            )
            ->get(route('admin.posts.create'))
            ->assertOk()
            ->assertViewIs('admin.posts.create-edit')
            ->assertViewHas(['post', 'categories', 'tags', 'users'])
        ;
    }

    /** @test */
    public function a_user_without_permission_cannot_create_posts() {
        $this->actingAs(
            $this->userWithAccess()
        );

        $this->get(
            route('admin.dashboard')
        )->assertOk();

        $this->get(
            route('admin.posts.create')
        )->assertForbidden();
    }
}
