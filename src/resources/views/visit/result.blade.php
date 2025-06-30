@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/visit/result.css') }}">
@endsection

@section('content')
<div class="result-container">
    <div class="result-card">
        @if ($status === 'invalid')
        <h2 class="result-title">無効なアクセスです</h2>
        <p class="result-message">指定されたリンクは存在しないか、有効期限が切れています。</p>
        @else
        <h2 class="result-title">不明な状態</h2>
        <p class="result-message">処理中に予期しないエラーが発生しました。</p>
        @endif
    </div>
</div>
@endsection