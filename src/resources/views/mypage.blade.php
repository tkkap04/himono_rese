@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-username">
    <h2>{{ $user->name }}さん</h2>
</div>


<div class="mypage-content">
    <div class="reservation-list">
        <h2 class="reservation-list__title">予約状況</h2>
        @if($reservations->isEmpty())
            <p>予約がありません。</p>
        @else
        <div class="reservation-list__box">
            @foreach($reservations as $reservation)
                <div class="reservation-list__card" data-reservation-id="{{ $reservation->id }}">
                    <div class="reservation-list__left">
                        <p class="reservation-list__item">予約{{ $loop->iteration }}</p>
                        <p class="reservation-list__item">Shop: {{ $reservation->shop->name }}</p>
                        <p class="reservation-list__item">Date: <span class="reservation-list__date">{{ $reservation->date }}</span></p>
                        <p class="reservation-list__item">Time: <span class="reservation-list__time">{{ $reservation->time }}</span></p>
                        <p class="reservation-list__item">Number: <span class="reservation-list__number">{{ $reservation->number_of_people }}人</span></p>
                    </div>

                    <div class="reservation-list__right">
                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="post" class="reservation-delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="reservation-list__delete-button">削除</button>
                        </form>

                        <button class="reservation-list__edit-button" data-reservation-id="{{ $reservation->id }}">変更</button>
                        
                        <div class="reservation-list__edit-form" style="display: none;">
                            <button class="reservation-list__cancel-button" data-reservation-id="{{ $reservation->id }}">取消</button>
                            <button class="reservation-list__save-button" data-reservation-id="{{ $reservation->id }}">保存</button>
                        </div>

                        <!-- QRコード表示ボタン -->
                        <button class="reservation-list__qr-button" data-reservation-id="{{ $reservation->id }}">QR</button>

                        <!-- QRコード表示エリア -->
                        <div id="qr-code-{{ $reservation->id }}" style="display:none;">
                            <img src="{{ asset('storage/qrcodes/' . $reservation->id . '.png') }}" alt="QR Code for reservation {{ $reservation->id }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
    <div class="shop-list">
        <h2 class="shop-list__title">お気に入り店舗</h2>
        <div class="shop-list__box">
            @foreach($favorites as $favorite)
            <div class="shop-list__card">
                <div class="shop-list__image" style="background-image: url('{{ $favorite->shop->image_url }}');"></div>
                <div class="shop-list__info">
                    <h3 class="shop-list__name">{{ $favorite->shop->name }}</h3>
                    <div class="shop-list__tag">
                        <p class="shop-list__area">#{{ $favorite->shop->area->name }}</p>
                        <p class="shop-list__genre">#{{ $favorite->shop->genre->name }}</p>
                    </div>
                    <div class="shop-list__button">
                        <a href="/detail/{{ $favorite->shop->id }}" class="shop-list__detail-button">詳しくみる</a>
                        <form action="{{ route('favorites.destroy', $favorite->shop->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="shop-list__favorite-button">❤️</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<script src="{{ asset('js/mypage.js') }}"></script>

@endsection
