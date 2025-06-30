@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
@endsection

@section('link')
@if($hasUnreviewed)
<div class="review-link-wrapper">
    <a href="{{ route('reviewed') }}" class="btn btn-primary">
        レビュー投稿はこちら
    </a>
</div>
@endif
@endsection

@section('content')
<div class="dashboard-container">
    <!-- 左カラム：予約情報 -->
    <div class="dashboard-left">
        <h2>予約状況</h2>

        @if ($errors->any())
        <div class="reservation-error-messages">
            <ul>
                @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if ($reservations->isEmpty())
        <p>予約はありません。</p>
        @else
        @foreach ($reservations as $index => $reservation)
        <div class="reservation-item" data-index="{{ $index }}">
            <div class="reservation-header toggle-header">
                <img src="{{ asset('images/time.png') }}" alt="予約{{ $index + 1 }}"
                    class="reservation-icon {{ $index !== 0 ? 'hidden' : '' }}">

                <span class="reservation-title">予約{{ $index + 1 }}</span>

                <span class="reservation-info">
                    {{ $reservation->reserved_date }}
                    {{ date('H:i', strtotime($reservation->reserved_time)) }}
                    {{ $reservation->shop->name }}
                </span>

                <span class="reservation-note hidden">日付、時間、人数の変更が可能です</span>

                <button type="button" class="reservation-delete-button">×</button>

                <form method="POST" action="{{ route('reservation.destroy', $reservation->id) }}"
                    class="reservation-delete-form hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <div class="reservation-details {{ $index !== 0 ? 'hidden' : '' }}">
                <form action="{{ route('reservation.update', $reservation->id) }}" method="POST"
                    class="reservation-update-form" novalidate>
                    @csrf
                    @method('PUT')
                    <table>
                        <tr>
                            <th>店舗</th>
                            <td>{{ $reservation->shop->name }}</td>
                        </tr>
                        <tr>
                            <th>日付</th>
                            <td>
                                <input type="date" name="reserved_date"
                                    value="{{ old('reserved_date', $reservation->reserved_date) }}" required>
                            </td>
                        </tr>
                        <tr>
                            <th>時間</th>
                            <td>
                                <select name="reserved_time" required>
                                    <option value="" disabled>----</option>
                                    @for ($hour = 10; $hour <= 22; $hour++) <option
                                        value="{{ sprintf('%02d:00', $hour) }}"
                                        {{ old('reserved_time', $reservation->reserved_time) === sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                        {{ sprintf('%02d:00', $hour) }}
                                        </option>
                                        <option value="{{ sprintf('%02d:30', $hour) }}"
                                            {{ old('reserved_time', $reservation->reserved_time) === sprintf('%02d:30', $hour) ? 'selected' : '' }}>
                                            {{ sprintf('%02d:30', $hour) }}
                                        </option>
                                        @endfor
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>人数</th>
                            <td>
                                <select name="number_of_people" required>
                                    <option value="" disabled>----</option>
                                    @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}"
                                        {{ old('number_of_people', $reservation->number_of_people) == $i ? 'selected' : '' }}>
                                        {{ $i }}人
                                        </option>
                                        @endfor
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td colspan=" 2">
                                <button type="submit" class="btn-update">予約変更</button>

                                <a href="{{ route('qr.show', ['reservation' => $reservation->id]) }}" class="btn-qr">
                                    QRコードを表示
                                </a>

                                @if(session('success'))
                                <span class="update-success-message">{{ session('success') }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        @endforeach

        <div id="deleteModal" class="modal hidden">
            <div class="modal-box">
                <p>予約を削除しますか？</p>
                <div class="modal-actions">
                    <button id="confirmDelete" class="btn-modal btn-yes">はい</button>
                    <button id="cancelDelete" class="btn-modal btn-no">いいえ</button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- 右カラム：ユーザー名とお気に入り -->
    <div class="dashboard-right">
        <h2>{{ $userName }}さん</h2>
        <h3>お気に入り店舗</h3>
        <div class="favorite-list">
            @foreach ($favorites as $shop)
            <div class="favorite-item">
                <img src="{{ asset('storage/image/' . $shop->image_path) }}" alt="{{ $shop->name }}">
                <h4>{{ $shop->name }}</h4>
                <p>#{{ $shop->area }} #{{ $shop->genre }}</p>
                <div class="favorite-actions">
                    <form action="{{ route('shop.detail', ['shop_id' => $shop->id]) }}" method="GET">
                        <button type="submit" class="btn-detail">詳しく見る</button>
                    </form>
                    <form action="{{ route('shop.favorite') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                        <button type="submit" class="btn-favorite-remove">♥</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/mypage.js') }}" defer></script>
@endsection