<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return match ($user->role) {
                1 => redirect('/'),
                2 => $this->handleShopManagerLogin($user),
                3 => redirect('/management'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。',
        ]);
    }

    protected function handleShopManagerLogin($user)
    {
        if (Hash::check('P@ssword', $user->password)) {
            return redirect()->route('password.change.form');
        }

        return redirect('/admin/attendance/list');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}