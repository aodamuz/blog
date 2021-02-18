<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller {
	/**
	 * Display the registration view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create() {
		return view('auth.register');
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @param  \App\Http\Requests\Auth\RegisterRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(RegisterRequest $request) {
		$data = $request->validated();

		$data['password'] = Hash::make($data['password']);

		$user = User::create(
			Arr::only($data, ['password', 'email'])
		);

		$user->option()->create(['items' => $data['option']]);

		if (config('auth.auto_login_registered_user')) {
			Auth::login($user);
		}

		event(new Registered($user));

		return redirect(RouteServiceProvider::HOME);
	}
}
