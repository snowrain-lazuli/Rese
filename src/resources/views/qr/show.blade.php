@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">来店用QRコード</h2>

    <div class="card p-4 mb-4">
        <p><strong>予約日時：</strong>{{ $reservation->reservation_day_time }}</p>
        <p><strong>店舗名：</strong>{{ $reservation->shop->name }}</p>
        <p><strong>利用者：</strong>{{ $reservation->user->name }} 様</p>
    </div>

    <div class="text-center">
        <h4 class="mb-3">以下のQRコードを店舗で提示してください</h4>
        <div class="d-inline-block p-3 border rounded bg-white">
            {!! $qrCode !!}
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('mypage') }}" class="btn btn-primary">マイページに戻る</a>
    </div>
</div>
@endsection