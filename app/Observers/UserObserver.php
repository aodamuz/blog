<?php

namespace App\Observers;

class UserObserver {
	/**
	 * Handle the model "creating" event.
	 *
	 * @param  Object $model
	 * @return void
	 */
	public function creating($model) {}

	/**
	 * Handle the model "created" event.
	 *
	 * @param  Object $model
	 * @return void
	 */
	public function created($model) {}
}
