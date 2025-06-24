@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">

<div class="container">
    <div class="left-panel">
        <div class="left-header">
            <button class="back-button" onclick="history.back();">&lt;</button>
            <h2 class="shop-name">{{ $shop->name }}</h2>
        </div>
        <img src="{{ asset('storage/image/' . $shop->image_path) }}" alt="{{ $shop->name }}" class="shop-image">
        <div class="tags">
            <span>#{{ $shop->area }}</span>
            <span>#{{ $shop->genre }}</span>
        </div>
        <p class="description">{{ $shop->description }}</p>
    </div>

    <div class="right-panel">
        <div class="reservation-box">
            <h3>予約</h3>
            <form id="reservation-form" action="{{ route('shop.reservation') }}" method="post">
                @csrf
                <input type="date" id="date" name="date">

                <select id="time" name="time">
                    <option value="" disabled selected>----</option>
                    @for ($hour = 10; $hour <= 22; $hour++) <option value="{{ sprintf('%02d:00', $hour) }}">
                        {{ sprintf('%02d:00', $hour) }}</option>
                        <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
                        @endfor
                </select>

                <select id="number" name="number">
                    <option value="" disabled selected>----</option>
                    @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}">{{ $i }}人</option>
                        @endfor
                </select>

                <div class="reservation-summary">
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

                <input type="hidden" value="{{ $shop->id }}" name="shop_id">

                <button type="submit" class="submit-button">予約する</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/show.js') }}" defer></script>
@endsection