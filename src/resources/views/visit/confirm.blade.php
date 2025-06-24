@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/visit/confirm.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/visit.css') }}">

<div class="visit-container">
    <div class="visit-card">
        <div class="visit-header">来店確認</div>

        <div class="visit-body">
            <div class="visit-info">
                <div>お名前</div>
                <div>{{ $reservation->user->name }}</div>

                <div>店舗名</div>
                <div>{{ $reservation->shop->name }}</div>

                <div>予約日</div>
                <div>{{ $reservation->reserved_date }}</div>

                <div>予約時間</div>
                <div>{{ date('H:i', strtotime($reservation->reserved_time)) }}</div>

                <div>人数</div>
                <div>{{ $reservation->number_of_people }} 人</div>

                <div>来店状況</div>
                <div>
                    @if ($reservation->visited)
                    <span class="status-visited">来店済み</span>
                    @else
                    <span class="status-not-visited">未来店</span>
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