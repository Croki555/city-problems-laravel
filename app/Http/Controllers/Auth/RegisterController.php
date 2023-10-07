<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function getRegister():View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'login' =>  ['exclude_if:email,null'],
            'email' => ['exclude_if:login,null|unique:' . User::class],
        ], [
            'login.unique'=> 'Логин занят',
            'email.unique'=> 'Данный адрес электронной почты занят'
        ]);

        if($request->has('name', 'surname', 'patronymic', 'login', 'email', 'password')) {
            $user = new User();
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->patronymic = $request->patronymic;
            $user->login = $request->login;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            event(new Registered($user));

            auth('web')->login($user);

            return redirect(route('home'));
        }
    }
}
