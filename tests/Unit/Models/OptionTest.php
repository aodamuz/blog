<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Tests\Assertion;
use App\Models\Option;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class OptionTest extends TestCase {
	use Assertion;

	/** @test */
	public function the_option_model_must_use_the_cachable_trait() {
		$this->assertClassUsesTrait(Cachable::class, Option::class);
	}
}
