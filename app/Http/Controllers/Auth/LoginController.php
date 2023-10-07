<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function login():View
    {
        return view('auth.login');
    }

    public function authenficate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => 'required',
        ]);

        if (auth('web')->attempt($data)) {
            $request->session()->regenerate();

            return redirect()->intended(route('profile'));
        }

        $request->session()->regenerate();

        return back()->withErrors([
            'login' => 'Предоставленные учетные данные не соответствуют нашим записям'
        ])->onlyInput('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
