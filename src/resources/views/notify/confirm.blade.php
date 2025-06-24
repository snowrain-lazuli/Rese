@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm-wrapper">
    <div class="confirm-container">
        <h2>お知らせメールの確認</h2>

        <form method="POST" action="{{ route('notify.send') }}">
            @csrf

            <p class="confirm-label">タイトル:</p>
            <p class="confirm-content">{{ $data['subject'] }}</p>

            <p class="confirm-label">本文:</p>
            <div class="confirm-preview">{{ $data['body'] }}</div>

            <input type="hidden" name="subject" value="{{ $data['subject'] }}">
            <textarea name="body" class="hidden-body">{{ $data['body'] }}</textarea>

            <button type="submit" class="confirm-button">送信</button>
        </form>
    </div>
</div>
@endsection


@section('js')
<script src="{{ asset('js/notify.js') }}" defer></script>
@endsection