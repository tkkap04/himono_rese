@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css') }}">
@endsection

@section('content')
    <div class="input">
        <div class="input-title">
            <h2 class="input-title__text">Casher</h2>
        </div>

        <div class="input-box">
            <label for="amount">支払い金額 (円):</label>
            <input type="number" id="amount" name="amount" class="input-box__item-input" required min="1">
        </div>

        <form id="payment-form" action="{{route('payment.process')}}" method="POST">
            @csrf
            <button type="button" id="customButton" class="stripe-button-el">
                <span>支払う</span>
            </button>
        </form>
    </div>

    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script src="{{ asset('js/stripe.js') }}"></script>
@endsection