@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail-content">
<!-- 店舗詳細 -->
    <div class="detail">
        <a class="detail__back" href="{{ route('shops.index') }}"><<</a>
        <p class="detail__name">{{ $shop->name }}</p>
        <img class="detail__image" src="{{ $shop->image_url }}" alt="{{ $shop->name }}">
        <p class="detail__tag">#{{ $shop->area->name }}</p>
        <p class="detail__tag">#{{ $shop->genre->name }}</p>
        <p class="detail__text">{{ $shop->description }}</p>
    </div>

<!-- 口コミ情報 -->
    <div class="review">
        @if(Auth::check() && Auth::user()->role === 'user' && !$hasUserReview)
            <div class="review-actions">
                <form action="{{ route('reviews.create', ['shopId' => $shop->id]) }}" class="review-actions__button" method="get">
                    <button type="submit" class="review-item__create-button">口コミを投稿する</button>
                </form>
            </div>
        @endif

        <div class="review-list">
            <div class="review-list__title">
                <p class="review-list__title-text">全ての口コミ情報</p>
            </div>
            @if($reviews->isEmpty())
                <p class="review-list__none">まだ口コミがありません。</p>
            @else
                @foreach($reviews as $review)
                    @if(!$reviews->isEmpty())
                        <hr class="review-list__separator">
                    @endif
                    <div class="review-item">
                        @auth
                            <div class="review-item__actions">
                                @if(Auth::user()->role === 'user' && $review->user_id === Auth::id())
                                    <a href="{{ route('reviews.edit', ['id' => $review->id]) }}" class="review-item__edit-button">口コミを編集</a>
                                @endif
                                @if((Auth::user()->role === 'user' && $review->user_id === Auth::id()) || Auth::user()->role === 'admin')
                                    <form action="{{ route('reviews.destroy', ['id' => $review->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="review-item__delete-button" onclick="return confirm('本当に削除しますか？')">口コミを削除</button>
                                    </form>
                                @endif
                            </div>
                        @endauth

                        <div class="review-item__rating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $review->rating ? 'star-blue' : 'star-gray' }}"></span>
                            @endfor
                        </div>
                        <p class="review-item__comment">{{ $review->comment }}</p>
                        @if($review->image_url)
                            <img src="{{ asset('storage/' . $review->image_url) }}" alt="口コミ画像" style="max-width: 200px;">
                        @else
                            <p>画像がありません</p>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
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


<script src="{{ asset('js/reservation.js') }}"></script>

@endsection