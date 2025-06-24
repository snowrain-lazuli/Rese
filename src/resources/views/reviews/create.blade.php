@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reviews/create.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="review-panel">
        <h2>レビューを書く</h2>

        <div class="info-row">
            <div class="info-label">店舗名</div>
            <div class="info-value">{{ $reservation->shop->name }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">来店日</div>
            <div class="info-value">{{ $reservation->reserved_date }}</div>
        </div>

        <form action="{{ route('review.store') }}" method="POST">
            @csrf

            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
            <input type="hidden" name="rating" id="rating" value="0">

            <div class="form-group rating-group">
                <label for="rating">評価</label>
                <div class="star-rating">
                    <span class="star" data-value="1">☆</span>
                    <span class="star" data-value="2">☆</span>
                    <span class="star" data-value="3">☆</span>
                    <span class="star" data-value="4">☆</span>
                    <span class="star" data-value="5">☆</span>
                </div>
                @error('rating')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="comment">コメント（任意）</label>
                <textarea name="comment" id="comment" rows="5" placeholder="ご感想をどうぞ">{{ old('comment') }}</textarea>
                @error('comment')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">投稿する</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/review.js') }}"></script>
@endsection