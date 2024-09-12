@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/success.css')}}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">会員登録ありがとうございます</h2>
    </div>
    <div class="input-box__item-submit">
        <a href="/login" class="input-box__item-submit-button" >ログインする</a>
    </div>
</div>
@endsection('content')