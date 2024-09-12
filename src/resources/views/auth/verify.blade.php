@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css')}}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">確認メールを送信しました。</h2>
    </div>
    <div>
        <p class="input-title__text-p">メール内のリンクを</br>クリックしてログインしてください。</p>
    </div>
    <div class="input-box__item-submit">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="input-box__item-submit-button" type="submit">確認メール再送信</button>
        </form>
    </div>
</div>
@endsection('content')