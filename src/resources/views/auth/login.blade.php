@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css')}}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">Login</h2>
    </div>

    <form class="input-box" action="/login" method="post">
        @csrf
        <div class="input-box">
            <div class="input-box__item__email">
                <input type="email" name="email" placeholder="Email" class="input-box__item-input" value="{{ old('email') }}" >
            </div>
            <div class="input-box__item__password">
                <input type="password" name="password" class="input-box__item-input" placeholder="Password" >
                <p class="input-box__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
                <p class="input-box__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="input-box__item-submit">
                <input type="submit" class="input-box__item-submit-button"  value="ログイン" >
            </div>
        </div>
    </form>
</div>
@endsection('content')