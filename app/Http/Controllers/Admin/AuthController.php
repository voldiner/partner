<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }


    public function logout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('welcome');

    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $data = $request->only('email', 'password');

        if (auth('admin')->attempt($data)){
            return redirect()->route('manager.index');
        }

        return redirect()->route('manager.login')->withErrors(['email' => 'Помилка - email чи пароль введені невірно'])->withInput();
    }
}
