@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection

@section('link')
<form class="notify-button-wrapper" method="get" action="{{ route('notify.form') }}">
    @csrf
    <button type="submit" class="btn-notify">お知らせメールを送信</button>
</form>
@endsection

@section('content')
<div class="owner-dashboard">
    {{-- 左カラム：店舗情報操作 --}}
    <div class="dashboard-left">
        <div class="shop-create">
            <h2>店舗情報 新規作成</h2>
            <form class="shop-form" action="{{ route('owner.shop.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                {{-- 店舗画像 --}}
                <div class="form-group">
                    <img src="" class="shop-image preview-create" style="display: none;" alt="preview">
                    <label class="label-file" for="image-create">店舗画像をアップロード</label>
                    <input type="file" name="image" id="image-create" class="input-file" data-form-type="create">
                    <p class="upload-status status-create"></p>
                    @error('image')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ショップ名 --}}
                <div class="form-group">
                    <label>ショップ名</label>
                    <input type="text" name="name" class="input-text" value="{{ old('name') }}">
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- エリア --}}
                <div class="form-group">
                    <label>エリア</label>
                    <input type="text" name="area" class="input-text" value="{{ old('area') }}">
                    @error('area')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ジャンル --}}
                <div class="form-group">
                    <label>ジャンル</label>
                    <input type="text" name="genre" class="input-text" value="{{ old('genre') }}">
                    @error('genre')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 店舗情報 --}}
                <div class="form-group">
                    <label>店舗情報</label>
                    <textarea name="description" class="input-textarea">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-create-shop">作成</button>
            </form>

        </div>

        <div class="shop-update">
            <h2>担当店舗情報</h2>
            @foreach($ownedShops as $shop)
            <form action="{{ route('owner.shop.modify', $shop->id) }}" method="POST" enctype="multipart/form-data"
                class="shop-edit-box">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <img src="{{ asset('storage/image/' . $shop->image_path) }}"
                        class="shop-image preview-{{ $shop->id }}" alt="{{ $shop->name }}">
                    <label class="label-file" for="image-{{ $shop->id }}">店舗画像をアップロード</label>
                    <input type="file" name="image" id="image-{{ $shop->id }}" class="input-file"
                        data-shop-id="{{ $shop->id }}">
                    <p class="upload-status status-{{ $shop->id }}"></p>
                </div>
                <div class="form-group">
                    <label>ショップ名</label>
                    <input type="text" name="name" class="input-text" value="{{ $shop->name }}">
                </div>
                <div class="form-group">
                    <label>エリア</label>
                    <input type="text" name="area" class="input-text" value="{{ $shop->area }}">
                </div>
                <div class="form-group">
                    <label>ジャンル</label>
                    <input type="text" name="genre" class="input-text" value="{{ $shop->genre }}">
                </div>
                <div class="form-group">
                    <label>店舗情報</label>
                    <textarea name="description" class="input-textarea">{{ $shop->description }}</textarea>
                </div>
                <button type="submit" class="btn-update-shop">更新</button>
            </form>
            @endforeach
        </div>
    </div>

    {{-- 右カラム：予約一覧 --}}
    <div class="dashboard-right">
        <div class="shop-reservations-panel">
            @foreach($ownedShops as $shop)
            <div class="shop-reservation-block">
                <h3 class="shop-title">{{ $shop->name }}</h3>
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