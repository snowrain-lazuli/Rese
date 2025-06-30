@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/notify/confirm.css') }}">
@endsection

@section('content')
<div class="confirm">
    <div class="confirm__container">
        <h2 class="confirm__title">お知らせメールの確認</h2>

        <form method="POST" action="{{ route('notify.send') }}" class="confirm__form">
            @csrf

            <p class="confirm__label">タイトル:</p>
            <p class="confirm__content">{{ $notifyData['subject'] }}</p>

            <p class="confirm__label">本文:</p>
            <div class="confirm__preview">{{ $notifyData['body'] }}</div>

            <input type="hidden" name="subject" value="{{ $notifyData['subject'] }}">
            <textarea name="body" class="confirm__hidden-body">{{ $notifyData['body'] }}</textarea>

            <button type="submit" class="confirm__button">送信</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/notify.js') }}" defer></script>
@endsection