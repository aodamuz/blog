<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseTest extends TestCase
{
    /** @test */
    public function the_base_model_must_be_an_abstract_class() {
        $this->assertAbstractClass(Base::class);
    }

    /** @test */
    public function the_base_model_must_be_a_subclass_of_the_model_class()
    {
        $this->assertSubclassOf(Base::class, Model::class);
    }

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

    /** @test */
    public function the_guarded_property_must_be_an_empty_array() {
        // The Category model is an extended class of the Base classes.
        // The Category class is tested because the Base class is abstract.
        $guarded = $this->getClassProperty(new Category, 'guarded');

        $this->assertEquals([], $guarded);
    }
}
