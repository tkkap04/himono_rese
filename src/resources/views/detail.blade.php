@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<!-- 店舗詳細 -->
<div class="detail-above">
<div class="detail">
    <a class="detail__back" href="{{ route('shops.index') }}"><<</a>
    <p class="detail__name">{{ $shop->name }}</p>
    <img class="detail__image" src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
    <p class="detail__tag">#{{ $shop->area->name }}</p>
    <p class="detail__tag">#{{ $shop->genre->name }}</p>
    <p class="detail__text">{{ $shop->description }}</p>
</div>

<!-- 予約フォーム -->
<div class="reservation">
     <form id="reservation-form" action="{{ route('reservations.store') }}" method="post">
        @csrf
        <p class="reservation-title">予約</p>
        <div class="reservation-form__date">
            <input type="date" id="reservation-date" name="date" class="reservation-form__date-input" required>
        </div>
        <div class="reservation-form__time">
            <select id="reservation-time" name="time" class="reservation-form__time-input" required>
            </select>
        </div>
        <div class="reservation-form__people">
            <select id="reservation-people" name="number_of_people" class="reservation-form__people-input" required>
            </select>
        </div>
        <div class="reservation-form__summary">
            <div id="reservation-summary" class="reservation-form__summary-input">
                <p class="reservation-form__summary-item">Shop <span class="reservation-form__summary-item" id="shop-name">{{ $shop->name }}</span></p>
                <p class="reservation-form__summary-item">Date <span class="reservation-form__summary-item" id="summary-date"></span></p>
                <p class="reservation-form__summary-item">Time <span class="reservation-form__summary-item" id="summary-time"></span></p>
                <p class="reservation-form__summary-item">Number <span class="reservation-form__summary-item" id="summary-people"></span></p>
            </div>
        </div>
        <p class="input-box__error-message">
            @error('date')
            {{ $message }}
            @enderror
        </p>
        <div class="reservation-form__submit">
            <button class="reservation-form__submit-button" type="submit">予約する</button>
        </div>
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
    </form>
</div>
</div>

<!-- 評価フォーム -->
<div class="detail-below">
    <div class="review">
        <p class="review-title">お店を評価する</p>
        <form action="{{ route('reviews.store', ['shopId' => $shop->id])  }}" method="post">
            @csrf
            <div class="review-rating">
                <label for="rating">Rating (1-5)</label>
                <select id="rating" name="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="review-comment">
                <label for="comment">コメント</label>
                <textarea id="comment" name="comment" class="review-comment__input" required></textarea>
            </div>
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <div class="review-submit">
                <button type="submit" class="review-submit__button">登録</button>
            </div>
        </form>

        <div class="review-average">Average Rating: {{ number_format($averageRating, 1) }}</div>

        <div class="reviews__list">
            @foreach($reviews as $review)
                <div class="review__item">
                    <p class="review__item-rating">Rating: {{ $review->rating }}</p>
                    <p class="review__item-comment">{{ $review->comment }}</p>
                    <p class="review__item-date">{{ $review->created_at->format('Y-m-d') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="{{ asset('js/reservation.js') }}"></script>

@endsection