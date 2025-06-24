@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/notify.css') }}">
@endsection

@section('content')
<div class="notify-container">
    <p>お知らせメールを送信しました。</p>
    <a href="{{ route('owner') }}">管理画面へ戻る</a>
</div>
@endsection


@section('js')
<script src="{{ asset('js/notify.js') }}" defer></script>
@endsection