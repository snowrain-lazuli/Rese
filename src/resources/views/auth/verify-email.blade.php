@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="bg-white shadow-md rounded-lg p-6 text-center">
        <h1 class="text-2xl font-bold mb-4">メール認証が必要です</h1>

        @if (session('status') === 'verification-link-sent')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            新しい認証リンクを送信しました。
        </div>
        @endif

        <p class="mb-4">
            ご登録のメールアドレスに認証リンクを送信しました。<br>
            届いたメールのリンクをクリックして認証を完了してください。
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                認証メールを再送信
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:underline">
                ログアウト
            </button>
        </form>
    </div>
</div>
@endsection