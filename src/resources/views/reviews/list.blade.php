@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reviews/list.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>レビュー未投稿の来店履歴</h2>

    @forelse($unreviewedReservations as $reservation)
    <div class="review-target-card">
        <p>店舗名：{{ $reservation->shop->name }}</p>
        <p>来店日：{{ $reservation->reserved_date }}</p>
        <a href="{{ route('review.create', ['reservation' => $reservation->id]) }}" class="btn btn-primary">
            レビューを書く
        </a>
    </div>
    @empty
    <p>レビューが未投稿の来店履歴はありません。</p>
    @endforelse
</div>
@endsection