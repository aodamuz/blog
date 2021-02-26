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
        $this->model->option($this->options);

        $this->assertEquals($this->options, $this->model->option());
    }

    /** @test */
    public function the_options_of_a_model_can_be_getted_from_a_key()
    {
        $this->model->option($this->options);

        $this->assertEquals($this->options, $this->model->option());

        $this->assertEquals('any', $this->model->option('bar'));
        $this->assertEquals(['any'], $this->model->option('baz'));
        $this->assertEquals('any', $this->model->option('foo.ass.bar'));
        $this->assertEquals('any', $this->model->option('foo.ass.baz'));
        $this->assertEquals('any', $this->model->option('foo.ass.foo'));

        $this->assertTrue(is_array($this->model->option('baz')));
        $this->assertTrue(is_array($this->model->option('foo.ass')));
    }

    /** @test */
    public function an_option_can_be_deleted_from_a_key()
    {
        $this->model->option($this->options);

        $this->assertEquals($this->options, $this->model->option());

        $this->assertEquals('any', $this->model->option('bar'));

        $this->model->forgetOption('bar');

        $this->assertNull($this->model->option('bar'));
    }

    /** @test */
    public function all_options_can_be_deleted()
    {
        $this->model->option($this->options);

        $this->assertEquals($this->options, $this->model->option());

        $this->model->flushOptions();

        $this->assertEquals([], $this->model->option());
    }
}
