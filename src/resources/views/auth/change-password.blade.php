@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/change-password.css') }}">
@endsection

@section('content')
<div class="change-password-wrapper">
    <h2 class="change-password-title">パスワード変更</h2>

    @if (session('status'))
    <div class="change-password-status">
        {{ session('status') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="change-password-errors">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="password">新しいパスワード</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワード（確認用）</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <div class="form-button">
            <button type="submit">変更する</button>
        </div>
    </form>
</div>
@endsection