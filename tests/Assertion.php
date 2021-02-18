<?php

namespace Tests;

trait Assertion {
	/**
	 * Asserts that a class uses a interface.
	 *
	 * @param mixed $interface
	 * @param mixed $object
	 *
	 * @throws ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws Exception
	 */
	public function assertClassUsesInterface($interface, $object) {
		$this->assertArrayHasKey(
			$interface,
			class_implements($object),
			"\"{$object}\" must use \"{$interface}\" interface"
		);
	}

	/**
	 * Asserts that a class uses a trait.
	 *
	 * @param mixed $trait
	 * @param mixed $object
	 *
	 * @throws ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws Exception
	 */
	public function assertClassUsesTrait($trait, $object) {
		$this->assertArrayHasKey(
			$trait,
			trait_uses_recursive($object),
			"\"{$object}\" must use \"{$trait}\" trait"
		);
	}
}
