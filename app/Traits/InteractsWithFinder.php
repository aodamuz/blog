<?php

namespace App\Traits;

use Symfony\Component\Finder\Finder;

trait InteractsWithFinder {
	/**
	 * Finder allows to build rules to find files and directories.
	 *
	 * @return \Symfony\Component\Finder\Finder
	 */
	public function finder() {
		return new Finder;
	}
}
