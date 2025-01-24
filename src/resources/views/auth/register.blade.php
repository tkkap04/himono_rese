@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css')}}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">Registration</h2>
    </div>

    <form class="input-box" action="/register" method="post">
        @csrf
        <div class="input-box__item__name">
            <input type="text" name="name" class="input-box__item-input" placeholder="Username" value="{{ old('name') }}" >
        </div>
        
        <div class="input-box__item__email">
            <input type="email" name="email" class="input-box__item-input" placeholder="Email" value="{{ old('email') }}" >
        </div>
        <div class="input-box__item__password">
            <input type="password" name="password" class="input-box__item-input" placeholder="Password" >

            <p class="input-box__error-message">
                @error('name')
                {{ $message }}
                @enderror
            </p>
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
            <input type="submit" class="input-box__item-submit-button" value="登録" >
        </div>
    </form>
</div>
@endsection('content')