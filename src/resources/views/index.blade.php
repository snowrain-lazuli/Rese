@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('link')
<div class="search-form-wrapper">
    <div class="search-form-container">
        <form method="POST" action="{{ route('shop.search') }}" class="search-form">
            @csrf

            <div class="search-form-group">
                <select name="area" class="search-form-select">
                    <option value="">All area</option>
                    @foreach ($areas as $area)
                    <option value="{{ $area }}" {{ old('area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
            </div>

            <div class="search-form-divider"></div>

            <div class="search-form-group">
                <select name="genre" class="search-form-select">
                    <option value="">All genre</option>
                    @foreach ($genres as $genre)
                    <option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="search-form-divider"></div>

            <div class="search-form-group search-form-input">
                <input type="text" name="keyword" placeholder="🔍 Search ..." value="{{ old('keyword') }}">
            </div>
        </form>
    </div>
</div>

@endsection

@section('content')

<div class="grid">
    @foreach ($shops as $shop)
    <div class="card">
        <img src="{{ asset('storage/image/' . $shop->image_path) }}" alt="{{ $shop->name }}">
        <div class="card-content">
            <h3>{{ $shop->name }}</h3>
            <p>#{{ $shop->area }} #{{ $shop->genre }}</p>
        </div>
        <div class="card-buttons">
            <a href="{{ route('shop.detail', $shop->id) }}">
                <button class="card-buttons_detail">詳しく見る</button>
            </a>
            <form method="POST" action="{{ route('shop.favorite') }}">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                <button type="submit" class="heart {{ in_array($shop->id, $favorites) ? 'active' : '' }}">
                    ♥
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection