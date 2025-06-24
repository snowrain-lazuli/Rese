@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('link')
@if($hasUnreviewed)
<div class="review-button-wrapper">
    <a href="{{ route('reviewed') }}" class="btn btn-primary">
        レビュー投稿はこちら
    </a>
</div>
@endif
@endsection

@section('content')
<div class="mypage-container">
    <!-- 左カラム：予約情報 -->
    <div class="left-column">
        <h2>予約状況</h2>

        @if ($reservations->isEmpty())
        <p>予約はありません。</p>
        @else
        @foreach ($reservations as $index => $reservation)
        <div class="reservation-card" data-index="{{ $index }}">
            {{-- 上部: アイコン・タイトル・削除 --}}
            <div class="reservation-header toggle-reservation">
                <img src="{{ asset('images/time.png') }}" alt="予約{{ $index + 1 }}"
                    class="reservation-icon {{ $index !== 0 ? 'mypage-hidden' : '' }}">

                <span class="reservation-label">予約{{ $index + 1 }}</span>

                <span class="reservation-summary">
                    {{ $reservation->reserved_date }}
                    {{ date('H:i', strtotime($reservation->reserved_time)) }}
                    {{ $reservation->shop->name }}
                </span>

                <span class="change-hint mypage-hidden">日付、時間、人数の変更が可能です</span>

                <button type="button" class="delete-button">×</button>

                <form method="POST" action="{{ route('reservation.destroy', $reservation->id) }}"
                    class="delete-reservation-form mypage-hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            {{-- 下部: 編集内容 --}}
            <div class="reservation-body {{ $index !== 0 ? 'mypage-hidden' : '' }}">
                <form action="{{ route('reservation.update', $reservation->id) }}" method="POST"
                    class="change-reservation-form">
                    @csrf
                    @method('PUT')
                    <table>
                        <tr>
                            <th>shop</th>
                            <td>{{ $reservation->shop->name }}</td>
                        </tr>
                        <tr>
                            <th>date</th>
                            <td>
                                <input type="date" name="reserved_date"
                                    value="{{ old('reserved_date', $reservation->reserved_date) }}" required>
                            </td>
                        </tr>
                        <tr>
                            <th>time</th>
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
                            <th>number</th>
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
                            <td colspan="2">
                                <button type="submit" class="change-reservation-button">予約変更</button>

                                <a href="{{ route('qr.show', ['reservation' => $reservation->id]) }}" class="qr_btn">
                                    QRコードを表示
                                </a>

                                @if(session('success'))
                                <span class="success-message">{{ session('success') }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        @endforeach


        <div id="deleteModal" class="modal-overlay mypage-hidden">
            <div class="modal-content">
                <p>予約を削除しますか？</p>
                <div class="modal-actions">
                    <button id="confirmDelete" class="btn-detail">はい</button>
                    <button id="cancelDelete" class="btn-detail">いいえ</button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- 右カラム：ユーザー名とお気に入り -->
    <div class="right-column">
        <h2>{{ $UserName }}さん</h2>
        <h3>お気に入り店舗</h3>
        <div class="favorites-grid">
            @foreach ($favorites as $shop)
            <div class="favorite-card">
                <img src="{{ asset('storage/image/' . $shop->image_path) }}" alt="{{ $shop->name }}">
                <h4>{{ $shop->name }}</h4>
                <p>#{{ $shop->area }} #{{ $shop->genre }}</p>
                <div class="card-actions">
                    <form action="{{ route('shop.detail', ['shop_id' => $shop->id]) }}" method="GET">
                        <button type="submit" class="btn-detail">詳しく見る</button>
                    </form>
                    <form action="{{ route('shop.favorite') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                        <button type="submit" class="btn-unlike">♥</button>
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