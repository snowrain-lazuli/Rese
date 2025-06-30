@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/reviews/list.css') }}">
@endsection

@section('content')
<div class="review-container">
    <h2 class="review-title">レビュー未投稿の来店履歴</h2>

    @forelse($unreviewedReservations as $reservation)
    <div class="review-card">
        <p class="review-shop">店舗名：{{ $reservation->shop->name }}</p>
        <p class="review-date">来店日：{{ $reservation->reserved_date }}</p>
        <a href="{{ route('review.create', ['reservation' => $reservation->id]) }}" class="btn-review">
            レビューを書く
        </a>
    </div>
    @empty
    <p class="review-empty">レビューが未投稿の来店履歴はありません。</p>
    @endforelse
</div>
@endsection