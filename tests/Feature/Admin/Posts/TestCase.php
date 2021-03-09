<?php

namespace Tests\Feature\Admin\Posts;

use Tests\TestCase as TestCaseBase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends TestCaseBase
{
    use RefreshDatabase;

    /**
     * Datos predetermidanos para crear y actualizar posts.
     *
     * @param array $overwrite
     *
     * @return array
     */
    protected function data($overwrite = [])
    {
        return array_merge([
            'title'       => 'Post Title',
            'slug'        => 'post-title',
            'body'        => 'Lorem ipsum dolor sit, amet consectetur, adipisicing elit.',
            'description' => 'Lorem ipsum dolor sit...',
        ], $overwrite);
    }
}
