@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/qr.css') }}">
@endsection

@section('content')
<div class="qr-container">
    <h2 class="qr-title">来店用QRコード</h2>

    <div class="qr-summary-card">
        <p><strong>予約日時：</strong>{{ $reservation->reservationDayTime }}</p>
        <p><strong>店舗名：</strong>{{ $reservation->shop->name }}</p>
        <p><strong>利用者：</strong>{{ $reservation->user->name }} 様</p>
    </div>

    <div class="qr-display-wrapper">
        <h4 class="qr-instruction">以下のQRコードを店舗で提示してください</h4>
        <div class="qr-box">
            {!! $qrCode !!}
        </div>
    </div>

    <div class="qr-back-link">
        <a href="{{ route('mypage') }}" class="btn-return-mypage">マイページに戻る</a>
    </div>
</div>
@endsection