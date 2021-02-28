<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Base;
use App\Models\User;
use App\Models\Country;
use App\Traits\HasSlug;
use App\Traits\HasOptions;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function countries_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('countries', [
                'title',
                'slug',
                'options',
            ])
        );
    }

    /** @test */
    public function the_country_model_must_be_a_subclass_of_the_base_model()
    {
        $this->assertTrue(is_subclass_of(Country::class, Base::class));
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
