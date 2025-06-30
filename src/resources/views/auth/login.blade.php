@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-title">Login</div>
        <form class="login-form" action="/login" method="post">
            @csrf
            <div class="login-form__group">
                <div class="login-form__input-wrapper">
                    <img src="{{ asset('images/mail.png') }}" class="login-form__image">
                    <input type="text" name="email" class="login-form-input" placeholder="Email">
                </div>
                @error('email')
                <p class="login-form__error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="login-form__group">
                <div class="login-form__input-wrapper">
                    <img src="{{ asset('images/lock.png') }}" class="login-form__image">
                    <input type="password" name="password" class="login-form-input" placeholder="Password">
                </div>
                @error('password')
                <p class="login-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="login-form-button">
                <button type="submit" class="login-button">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection