<?php

namespace App\Traits;

use Illuminate\Filesystem\Filesystem;

trait InteractsWithFilesystem {
	/**
	 * Return a fresh instance of Filesystem.
	 *
	 * @return \Illuminate\Filesystem\Filesystem
	 */
	public function files() {
		return new Filesystem;
	}
}
