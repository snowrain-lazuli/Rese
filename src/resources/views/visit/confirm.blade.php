@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/visit/confirm.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/visit.css') }}">

<div class="visit-container">
    <div class="visit-card">
        <div class="visit-card__header">来店確認</div>

        <div class="visit-card__body">
            <div class="visit-info">
                <div class="visit-info__label">お名前</div>
                <div class="visit-info__value">{{ $reservation->user->name }}</div>

                <div class="visit-info__label">店舗名</div>
                <div class="visit-info__value">{{ $reservation->shop->name }}</div>

                <div class="visit-info__label">予約日</div>
                <div class="visit-info__value">{{ $reservation->reserved_date }}</div>

                <div class="visit-info__label">予約時間</div>
                <div class="visit-info__value">{{ date('H:i', strtotime($reservation->reserved_time)) }}</div>

                <div class="visit-info__label">人数</div>
                <div class="visit-info__value">{{ $reservation->number_of_people }} 人</div>

                <div class="visit-info__label">来店状況</div>
                <div class="visit-info__value">
                    @if ($reservation->visited)
                    <span class="visit-status visit-status--visited">来店済み</span>
                    @else
                    <span class="visit-status visit-status--not-visited">未来店</span>
                    @endif
                </div>
            </div>

            @if (!$reservation->visited)
            <form action="{{ route('visit.mark', ['reservation' => $reservation->id]) }}" method="POST">
                @csrf
                <button type="submit" class="visit-btn">来店済みにする</button>
            </form>
            @else
            <div class="visit-message">この予約はすでに来店済みとして登録されています。</div>
            @endif
        </div>
    </div>
</div>
@endsection