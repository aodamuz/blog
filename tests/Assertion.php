<?php

namespace Tests;

use ReflectionClass;
use Illuminate\Support\Facades\Schema;

trait Assertion
{
    /**
     * Asserts that a class uses a interface.
     *
     * @param string $interface
     * @param string|object $object
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     */
    public function assertClassUsesInterface(string $interface, $object)
    {
        $object = is_object($object) ? get_class($object) : $object;

        $this->assertArrayHasKey(
            $interface,
            class_implements($object),
            "\"{$object}\" must use \"{$interface}\" interface"
        );
    }

    /**
     * Asserts that a class uses a trait.
     *
     * @param string $trait
     * @param string|object $object
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws Exception
     */
    public function assertClassUsesTrait(string $trait, $object)
    {
        $object = is_object($object) ? get_class($object) : $object;

        $this->assertArrayHasKey(
            $trait,
            trait_uses_recursive($object),
            "\"{$object}\" must use \"{$trait}\" trait"
        );
    }

    /**
     * Asserts that a class is a subclass of a given class.
     *
     * @param string|object $child
     * @param string|object $parent
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function assertSubclassOf($child, $parent)
    {
        $child = is_object($child) ? get_class($child) : $child;
        $parent = is_object($parent) ? get_class($parent) : $parent;

        $this->assertTrue(
            is_subclass_of($child, $parent),
            "The \"{$child}\" class must be a subclass of \"{$parent}\"."
        );
    }

    /**
     * It asserts that a class is abstract.
     *
     * @param string|object $class
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function assertAbstractClass($class)
    {
        $reflection = new ReflectionClass($class);

        $this->assertTrue(
            $reflection->isAbstract(),
            "The \"{$class}\" class must be an abstract class."
        );
    }

    /**
     * Assert that a table contains the given columns.
     *
     * @param string $table
     * @param array $columns
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function assertDatabaseHasColumns(string $table, array $columns)
    {
        $cols = implode(', ', $columns);

        $this->assertTrue(
            Schema::hasColumns($table, $columns),
            "The table \"{$table}\" must contain the columns: {$cols}."
        );
    }
}
