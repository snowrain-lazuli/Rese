@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shops/done.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/reservation-complete.css') }}">

<div class="reservation-complete-container">
    <div class="reservation-complete-panel">
        <p class="reservation-complete-message">ご予約ありがとうございます。</p>
        <form action="{{ route('shop.detail', ['shop_id' => $shopId]) }}" method="get">
            @csrf
            <button type="submit" class="reservation-back-button">戻る</button>
        </form>
    </div>
</div>
@endsection