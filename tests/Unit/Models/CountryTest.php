<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\User;
use App\Models\Country;
use App\Traits\HasSlug;
use App\Traits\HasOptions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function countries_database_has_expected_columns()
    {
        $this->assertDatabaseHasColumns('countries', [
            'id',
            'title',
            'slug',
            'options',
        ]);
    }

    /** @test */
    public function the_country_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertSubclassOf(Country::class, Base::class);
    }

    /** @test */
    public function the_country_model_must_use_the_has_slug_trait() {
        $this->assertClassUsesTrait(HasSlug::class, Country::class);
    }

    /** @test */
    public function the_country_model_must_use_the_has_options_trait()
    {
        $this->assertClassUsesTrait(HasOptions::class, Country::class);
    }

    /** @test */
    public function the_casts_property_must_define_the_options_as_an_array() {
        $value = $this->getClassProperty(new Country, 'casts');

        $this->assertTrue($value['options'] == 'array');
    }

    /** @test */
    public function a_country_has_many_users()
    {
        // Create additional categories to make sure that
        // the users belong to the expected country.
        Country::factory()->times(3)->create();

        $country = Country::factory()
            ->hasUsers(3)
            ->create();

        $this->assertEquals(
            User::pluck('id')->toArray(),
            $country->users->pluck('id')->toArray()
        );
    }
}
