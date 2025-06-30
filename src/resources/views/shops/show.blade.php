@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shops/show.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/shop-detail.css') }}">

<div class="shop-detail-container">
    <div class="shop-info-panel">
        <div class="shop-header">
            <button class="shop-back-button" onclick="history.back();">&lt;</button>
            <h2 class="shop-title">{{ $shop->name }}</h2>
        </div>
        <img src="{{ asset('storage/image/' . $shop->image_path) }}" alt="{{ $shop->name }}" class="shop-thumbnail">
        <div class="shop-tags">
            <span>#{{ $shop->area }}</span>
            <span>#{{ $shop->genre }}</span>
        </div>
        <p class="shop-description">{{ $shop->description }}</p>
    </div>

    <div class="reservation-panel">
        <div class="reservation-form-box">
            <h3>予約</h3>
            <form id="reservation-form" action="{{ route('shop.reservation') }}" method="post" novalidate>
                @csrf
                <input type="date" id="reservation-date" name="date">

                <select id="reservation-time" name="time">
                    <option value="" disabled selected>----</option>
                    @for ($hour = 10; $hour <= 22; $hour++) <option value="{{ sprintf('%02d:00', $hour) }}">
                        {{ sprintf('%02d:00', $hour) }}</option>
                        <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
                        @endfor
                </select>

                <select id="reservation-number" name="number">
                    <option value="" disabled selected>----</option>
                    @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}">{{ $i }}人</option>
                        @endfor
                </select>

                <div class="reservation-summary-box">
                    <table>
                        <tr>
                            <td>Shop</td>
                            <td id="summary-shop">{{ $shop->name }}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td id="summary-date">----</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td id="summary-time">----</td>
                        </tr>
                        <tr>
                            <td>Number</td>
                            <td id="summary-number">--人</td>
                        </tr>
                    </table>
                </div>

                @if ($errors->any())
                <div class="reservation-error-messages">
                    <ul>
                        @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <input type="hidden" value="{{ $shop->id }}" name="shop_id">
                <button type="submit" class="reservation-submit-button">予約する</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/show.js') }}" defer></script>
@endsection