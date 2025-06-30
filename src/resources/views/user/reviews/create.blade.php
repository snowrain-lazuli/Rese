@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/reviews/create.css') }}">
@endsection

@section('content')
<div class="review-container">
    <div class="review-panel">
        <h2 class="review-title">レビューを書く</h2>

        <div class="review-info-row">
            <div class="review-label">店舗名</div>
            <div class="review-value">{{ $reservation->shop->name }}</div>
        </div>

        <div class="review-info-row">
            <div class="review-label">来店日</div>
            <div class="review-value">{{ $reservation->reserved_date }}</div>
        </div>

        <form action="{{ route('review.store') }}" method="POST">
            @csrf

            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
            <input type="hidden" name="rating" id="rating" value="">

            <div class="review-form-group rating-group">
                <label for="rating">評価</label>
                <div class="star-group">
                    <span class="star" data-value="1">☆</span>
                    <span class="star" data-value="2">☆</span>
                    <span class="star" data-value="3">☆</span>
                    <span class="star" data-value="4">☆</span>
                    <span class="star" data-value="5">☆</span>
                </div>
            </div>
            @error('rating')
            <div class="form-error">{{ $message }}</div>
            @enderror

            <div class="review-form-group">
                <label for="comment">コメント</label>
                <textarea name="comment" id="comment" rows="5" placeholder="ご感想をどうぞ">{{ old('comment') }}</textarea>
                @error('comment')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit-review">投稿する</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/review.js') }}"></script>
@endsection