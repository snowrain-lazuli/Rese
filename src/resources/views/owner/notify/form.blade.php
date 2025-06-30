@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/notify/notify.css') }}">
@endsection

@section('content')
<div class="notify-panel">
    <h2 class="notify-panel__title">お知らせメールの作成</h2>

    <form method="POST" action="{{ route('notify.confirm') }}" class="notify-form">
        @csrf
        <label for="notify-subject" class="notify-form__label">タイトル</label>
        <input type="text" id="notify-subject" name="subject" required class="notify-form__input">

        <label for="notify-body" class="notify-form__label">本文</label>
        <textarea id="notify-body" name="body" rows="5" required class="notify-form__textarea"></textarea>

        <button type="submit" class="btn btn-primary notify-form__submit">確認へ進む</button>
    </form>
</div>
@endsection


@section('js')
<script src="{{ asset('js/notify.js') }}" defer></script>
@endsection