@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">

<div class="container">
    <div class="done-panel">
        <p class="done-message">ご予約ありがとうございます。</p>
        <form action="{{ route('shop.detail', ['shop_id' => $shop_id]) }}" method="get">
            @csrf
            <button type="submit" class="submit-button">戻る</button>
        </form>
    </div>
</div>

@endsection