<?php

namespace Tests\Unit\Repositories\Posts;

use Tests\TestCase;
use App\Repositories\Repository;

class RepositoryTest extends TestCase
{
    /** @test */
    public function the_base_repository_must_be_an_abstract_class() {
        $this->assertAbstractClass(Repository::class);
    }
}
