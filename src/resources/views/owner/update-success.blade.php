@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/success.css')}}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">店舗情報を更新しました</h2>
    </div>
    <div class="input-box__item-submit">
        <a href="/owner/update-shop" class="input-box__item-submit-button" >Update Shopページへ</a>
    </div>
</div>
@endsection('content')