@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/notify/notify.css') }}">
@endsection

@section('content')
<div class="notify-message">
    <p class="notify-message__text">お知らせメールを送信しました。</p>
    <a href="{{ route('owner') }}" class="notify-message__link">管理画面へ戻る</a>
</div>
@endsection

@section('js')
<script src="{{ asset('js/notify.js') }}" defer></script>
@endsection