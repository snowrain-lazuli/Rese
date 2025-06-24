@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner.css') }}">
@endsection

@section('link')
<form class="header-mail-btn" method="get" action="{{ route('notify.form') }}">
    @csrf
    <button type="submit" class="btn-notify">お知らせメールを送信</button>
</form>
@endsection

@section('content')
<div class="owner-dashboard">
    {{-- 左カラム：店舗情報操作 --}}
    <div class="left-panel">
        <div class="shop-create-panel">
            <h2>店舗情報 新規作成</h2>
            <form class="shop-form-area" action="{{ route('owner.shop.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <img src="" class="shop-img preview-create" style="display: none;" alt="preview">
                    <label class="custom-file-label" for="image-create">店舗画像をアップロード</label>
                    <input type="file" name="image" id="image-create" class="custom-file-input" data-form-type="create">
                    <p class="upload-status upload-status-create"></p>
                </div>
                <div class="form-group">
                    <label>ショップ名</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label>エリア</label>
                    <input type="text" name="area" class="form-control">
                </div>
                <div class="form-group">
                    <label>ジャンル</label>
                    <input type="text" name="genre" class="form-control">
                </div>
                <div class="form-group">
                    <label>店舗情報</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn-create">作成</button>
            </form>
        </div>

        <div class="shop-update-panel">
            <h2>担当店舗情報</h2>
            @foreach($shops as $shop)
            <form action="{{ route('owner.shop.modify', $shop->id) }}" method="POST" enctype="multipart/form-data"
                class="shop-box">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <img src="{{ asset('storage/image/' . $shop->image_path) }}"
                        class="shop-img preview-{{ $shop->id }}" alt="{{ $shop->name }}">
                    <label class="custom-file-label" for="image-{{ $shop->id }}">店舗画像をアップロード</label>
                    <input type="file" name="image" id="image-{{ $shop->id }}" class="custom-file-input"
                        data-shop-id="{{ $shop->id }}">
                    <p class="upload-status upload-status-{{ $shop->id }}"></p>
                </div>
                <div class="form-group">
                    <label>ショップ名</label>
                    <input type="text" name="name" value="{{ $shop->name }}">
                </div>
                <div class="form-group">
                    <label>エリア</label>
                    <input type="text" name="area" value="{{ $shop->area }}">
                </div>
                <div class="form-group">
                    <label>ジャンル</label>
                    <input type="text" name="genre" value="{{ $shop->genre }}">
                </div>
                <div class="form-group">
                    <label>店舗情報</label>
                    <textarea name="description">{{ $shop->description }}</textarea>
                </div>
                <button type="submit" class="btn-update">更新</button>
            </form>
            @endforeach
        </div>
    </div>

    {{-- 右カラム：予約一覧 --}}
    <div class="right-panel">
        <div class="shop-reservation-panel">
            @foreach($shops as $shop)
            <div class="shop-reservations">
                <h3>{{ $shop->name }}</h3>
                @forelse($shop->reservations as $reservation)
                <div class="reservation-card">
                    <p><strong>予約者名：</strong>{{ $reservation->user->name }}</p>
                    <p><strong>日付：</strong>{{ $reservation->reserved_date }}</p>
                    <p><strong>時間：</strong>{{ $reservation->reserved_time }}</p>
                    <p><strong>人数：</strong>{{ $reservation->number_of_people }}人</p>
                </div>
                @empty
                <p>予約はありません。</p>
                @endforelse
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/owner.js') }}" defer></script>
@endsection