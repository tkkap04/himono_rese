@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">ご予約ありがとうございます</h2>
    </div>
    <div class="input-box__item-submit">
        <a href="/mypage" class="input-box__item-submit-button" >マイページへ戻る</a>
    </div>
</div>
@endsection('content')