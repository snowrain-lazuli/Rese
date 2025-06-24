@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-title">Register</div>
        <form class="register-form" action="{{ route('register') }}" method="post">
            @csrf
            <div class="register-form__group">
                <img src="{{ asset('images/account.png') }}" class="register-form__image">
                <input type="text" name="name" class="register-form-input" placeholder="Username">
                @error('name')
                <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <img src="{{ asset('images/mail.png') }}" class="register-form__image">
                <input type="email" name="email" class="register-form-input" placeholder="Email">
                @error('email')
                <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <img src="{{ asset('images/lock.png') }}" class="register-form__image">
                <input type="password" name="password" class="register-form-input" placeholder="Password">
                @error('password')
                <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form-button">
                <button type="submit" class="register-button">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection