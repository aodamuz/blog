<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasOptionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = User::factory()->create(['options' => []]);

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
    public function a_model_can_store_an_array_of_options()
    {
        $this->model->set($this->options);

        $this->assertEquals($this->options, $this->model->get());
    }

    /** @test */
    public function the_options_of_a_model_can_be_getted_from_a_key()
    {
        $this->model->set($this->options);

        $this->assertEquals($this->options, $this->model->get());

        $this->assertEquals('any', $this->model->get('bar'));
        $this->assertEquals(['any'], $this->model->get('baz'));
        $this->assertEquals('any', $this->model->get('foo.ass.bar'));
        $this->assertEquals('any', $this->model->get('foo.ass.baz'));
        $this->assertEquals('any', $this->model->get('foo.ass.foo'));

        $this->assertTrue(is_array($this->model->get('baz')));
        $this->assertTrue(is_array($this->model->get('foo.ass')));

        $this->model->set('dot.bar.baz.far.foo', 'any');

        $this->assertEquals('any', $this->model->get('dot.bar.baz.far.foo'));

        $this->assertTrue(is_array($this->model->get('dot')));
        $this->assertTrue(is_array($this->model->get('dot.bar')));
        $this->assertTrue(is_array($this->model->get('dot.bar.baz')));
        $this->assertTrue(is_array($this->model->get('dot.bar.baz.far')));
    }

    /** @test */
    public function an_option_can_be_deleted_from_a_key()
    {
        $this->model->set($this->options);

        $this->assertEquals($this->options, $this->model->get());

        $this->assertEquals('any', $this->model->get('bar'));

        $this->model->forget('bar');

        $this->assertNull($this->model->get('bar'));
    }

    /** @test */
    public function all_options_can_be_deleted()
    {
        $this->model->set($this->options);

        $this->assertEquals($this->options, $this->model->get());

        $this->model->flush();

        $this->assertEquals([], $this->model->get());
    }
}
