@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/notify.css') }}">
@endsection

@section('content')
<div class="notify-container">
    <h2>お知らせメールの作成</h2>

    <form method="POST" action="{{ route('notify.confirm') }}">
        @csrf
        <label>タイトル</label>
        <input type="text" name="subject" required>

        <label>本文</label>
        <textarea name="body" rows="5" required></textarea>

        <button type="submit">確認へ進む</button>
    </form>
</div>
@endsection


@section('js')
<script src="{{ asset('js/notify.js') }}" defer></script>
@endsection