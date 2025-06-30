@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-container">
    <div class="verify-card">
        <h1 class="verify-title">メール認証が必要です</h1>

        @if (session('status') === 'verification-link-sent')
        <div class="verify-success">
            新しい認証リンクを送信しました。
        </div>
        @endif

        <p class="verify-message">
            ご登録のメールアドレスに認証リンクを送信しました。<br>
            届いたメールのリンクをクリックして認証を完了してください。
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify-resend-button">
                認証メールを再送信
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="verify-logout-form">
            @csrf
            <button type="submit" class="verify-logout-button">
                ログアウト
            </button>
        </form>
    </div>
</div>
@endsection