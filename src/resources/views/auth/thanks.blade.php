@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">

<div class="container">
    <div class="thanks-panel">
        <p class="thanks-message">会員登録ありがとうございます</p>
        <form action="{{ route('login') }}" method="get">
            @csrf
            <button type="submit" class="submit-button">ログインする</button>
        </form>
    </div>
</div>

@endsection