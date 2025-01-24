@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css')}}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">Create Owner</h2>
    </div>

    <form class="input-box" action="{{ route('admin.createOwner') }}" method="post">
        @csrf
        <div class="input-box__item__name">
            <label for="name">Name</label>
            <input type="text" class="input-box__item-input" id="name" name="name" required>
        </div>
        <div class="input-box__item__email">
            <label for="email">Email</label>
            <input type="email" class="input-box__item-input" id="email" name="email" required>
        </div>
        <div class="input-box__item__password">
            <label for="password">Password</label>
            <input type="password" class="input-box__item-input" id="password" name="password" required>
        </div>
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
        <div class="input-box__item-submit">
            <input type="submit" class="input-box__item-submit-button" value="作成" >
        </div>
    </form>
</div>
@endsection
