<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use Tests\Assertion;
use App\Traits\HasOptions;
use Cviebrock\EloquentSluggable\Sluggable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseTest extends TestCase
{
    use Assertion;

    /** @test */
    public function the_base_model_must_use_the_has_factory_trait()
    {
        $this->assertClassUsesTrait(HasFactory::class, Base::class);
    }

    /** @test */
    public function the_base_model_must_use_the_has_option_trait()
    {
        $this->assertClassUsesTrait(HasOptions::class, Base::class);
    }

    /** @test */
    public function the_base_model_must_use_the_cachable_trait()
    {
        $this->assertClassUsesTrait(Cachable::class, Base::class);
    }

    /** @test */
    public function the_base_model_must_use_the_sluggable_trait()
    {
        $this->assertClassUsesTrait(Sluggable::class, Base::class);
    }
}
