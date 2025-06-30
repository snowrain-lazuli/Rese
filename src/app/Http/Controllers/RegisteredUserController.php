<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AdminRegisterRequest;

class RegisteredUserController extends Controller
{
    // 一般ユーザー登録フォーム
    public function showUserRegisterForm()
    {
        return view('auth.register');
    }

    // 管理者登録フォーム（店長用）
    public function showAdminRegisterForm()
    {
        return view('auth.admin-register');
    }

    // 一般ユーザー登録（role = 1）+ ログイン + 認証メール送信
    public function registerUser(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1,
        ]);

        event(new Registered($user)); // 認証メール送信

        auth()->login($user); // ← ここで自動ログイン

        return redirect()->route('verification.notice'); // 認証メール案内画面へ
    }

    // 店長登録（role = 2）※ログインしない
    public function registerAdmin(AdminRegisterRequest $request)
    {
        $temporaryPassword = 'Password123!'; // 仮パスワード

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($temporaryPassword),
            'role' => 2, // 店長として登録
        ]);

        event(new Registered($user)); // 認証メール送信（要）

        return redirect()->route('show.admin.register')->with('status', '店長を登録しました（仮パスワード: ' . $temporaryPassword . '）');
    }
}