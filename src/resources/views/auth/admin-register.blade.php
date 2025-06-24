@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-title">Register</div>
        <form class="register-form" action="{{ route('admin.register') }}" method="post">
            @csrf
            <div class="register-form__group">
                <div class="register-form__input-wrapper">
                    <img src="{{ asset('images/account.png') }}" class="register-form__image">
                    <input type="text" name="name" class="register-form-input" placeholder="Username">
                </div>
                @error('name') <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <div class="register-form__input-wrapper">
                    <img src="{{ asset('images/mail.png') }}" class="register-form__image">
                    <input type="email" name="email" class="register-form-input" placeholder="Email">
                </div>
                @error('email')
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