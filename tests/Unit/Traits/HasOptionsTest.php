<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use App\Models\Base;
use App\Models\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasOptionsTest extends TestCase {
	use RefreshDatabase;

	protected function setUp(): void {
		parent::setUp();

		$this->model = new ModelWithOption(['id' => 1]);

		$this->model->option()->create(['items' => []]);

		$this->options = [
			'bar' => 'any',
			'baz' => ['any'],
			'foo' => [
				'ass' => [
					'bar' => 'any',
					'baz' => 'any',
					'foo' => 'any',
				]
			],
		];
	}

	/** @test */
	public function a_model_morph_one_option() {
		$this->assertInstanceOf(Option::class, $this->model->option);
	}

	/** @test */
	public function a_model_can_store_an_array_of_options() {
		$this->model->option->set($this->options);

		$this->assertEquals($this->options, $this->model->option->get());
	}

	/** @test */
	public function the_options_of_a_model_can_be_getted_from_a_key() {
		$this->model->option->set($this->options);

		$this->assertEquals($this->options, $this->model->option->get());

		$this->assertEquals('any', $this->model->option->get('bar'));
		$this->assertEquals(['any'], $this->model->option->get('baz'));
		$this->assertEquals('any', $this->model->option->get('foo.ass.bar'));
		$this->assertEquals('any', $this->model->option->get('foo.ass.baz'));
		$this->assertEquals('any', $this->model->option->get('foo.ass.foo'));

		$this->assertTrue(is_array($this->model->option->get('baz')));
		$this->assertTrue(is_array($this->model->option->get('foo.ass')));

		$this->model->option->set('dot.bar.baz.far.foo', 'any');

		$this->assertEquals('any', $this->model->option->get('dot.bar.baz.far.foo'));

		$this->assertTrue(is_array($this->model->option->get('dot')));
		$this->assertTrue(is_array($this->model->option->get('dot.bar')));
		$this->assertTrue(is_array($this->model->option->get('dot.bar.baz')));
		$this->assertTrue(is_array($this->model->option->get('dot.bar.baz.far')));
	}

	/** @test */
	public function an_option_can_be_deleted_from_a_key() {
		$this->model->option->set($this->options);

		$this->assertEquals($this->options, $this->model->option->get());

		$this->assertEquals('any', $this->model->option->get('bar'));

		$this->model->option->forget('bar');

		$this->assertNull($this->model->option->get('bar'));
	}

	/** @test */
	public function all_options_can_be_deleted() {
		$this->model->option->set($this->options);

		$this->assertEquals($this->options, $this->model->option->get());

		$this->model->option->flush();

		$this->assertEquals([], $this->model->option->get());
	}
}

/**
 * Fake model
 */
class ModelWithOption extends Base {}
