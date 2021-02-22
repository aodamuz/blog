<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Arr;
use App\Support\Config\ConfigKeys;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
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
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create(
            Arr::only($data, ['password', 'email'])
        );

        $user->option->set($data['option']);

        event(new Registered($user));

        if (config(ConfigKeys::AUTO_LOGIN)) {
            Auth::login($user);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
