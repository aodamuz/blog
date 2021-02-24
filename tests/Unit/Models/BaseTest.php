<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseTest extends TestCase
{
    /** @test */
    public function the_base_model_must_use_the_has_factory_trait()
    {
        $this->assertClassUsesTrait(HasFactory::class, Base::class);
    }

    /** @test */
    public function the_base_model_must_use_the_cachable_trait()
    {
        $this->assertClassUsesTrait(Cachable::class, Base::class);
    }
}
