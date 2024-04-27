<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Rules\Recaptcha;
use App\Rules\NoSpaces;
use \Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {

        if (url()->previous() != url()->current() && url()->previous() != route('login')){
            Session::put('beforeregister', url()->previous());
        }


        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'username'              => ['required', 'string', 'min:8', 'max:20', 'unique:users,username', new NoSpaces],
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|confirmed|min:8',
            'day'                   => 'required|int',
            'month'                 => 'required|int',
            'year'                  => 'required|int',
            'terms'                 => 'accepted',
            'subscribe'             => 'nullable',
            'g-recaptcha-response'  => ['required', new Recaptcha]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
