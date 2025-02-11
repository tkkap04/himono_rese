@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')

<div class="create-content">
    <div class="shop-card">
        <p class="shop-card__text">今回のご利用はいかがでしたか？</p>
        <div class="shop-list__card">
            <div class="shop-list__image" style="background-image: url('{{ $shop->image_url }}');"></div>
            <div class="shop-list__info">
                <h3 class="shop-list__name">{{ $shop->name }}</h3>
                <div class="shop-list__tag">
                    <p class="shop-list__area">#{{ $shop->area->name }}</p>
                    <p class="shop-list__genre">#{{ $shop->genre->name }}</p>
                </div>
                <div class="shop-list__button">
                    <a href="{{ route('shop.detail', $shop->id) }}" class="shop-list__detail-button">詳しくみる</a>

                    @if(Auth::check() && $shop->favoritedBy(Auth::user()))
                    <form action="{{ route('favorites.destroy', $shop->id) }}" method="POST" class="favorite-form" data-shop-id="{{ $shop->id }}">
                        @csrf
                        @method('DELETE')
                        <img class="shop-list__favorite-icon" src="/images/heart_red.png" alt="お気に入り">
                    </form>
                    @else
                    <form action="{{ route('favorites.store') }}" method="POST" class="favorite-form" data-shop-id="{{ $shop->id }}">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <img class="shop-list__favorite-icon" src="/images/heart_gray.png" alt="お気に入り">
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="create-form">
        <div class="create-form__title">
            <p class="create-form__text">体験を評価してください</p>
        </div>
        <p class="input-box__error-message">
            @error('rating')
            {{ $message }}
            @enderror
        </p>
        <form action="{{ isset($review) ? route('reviews.update', ['id' => $review->id]) : route('reviews.store', ['id' => $shop->id]) }}" 
        method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($review))
                @method('PUT')
            @endif

            <div class="create-form__rating">
                <div class="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ (isset($review) && $review->rating == $i) ? 'checked' : '' }}>
                        <label for="star{{ $i }}" class="rating__star" data-value="{{ $i }}"></label>
                    @endfor
                </div>
            </div>

            <div class="create-form__comment">
                <p class="create-form__text"><label for="comment">口コミを投稿</label></p>
                <p class="input-box__error-message">
                    @error('comment')
                    {{ $message }}
                    @enderror
                </p>
                <textarea class="create-form__text-input" name="comment" id="comment" maxlength="400">{{ old('comment', isset($review) ? $review->comment : '') }}</textarea>
                <p class="create-form__text-count" id="char-count">0/400(最高文字数)</p>
            </div>

            <div class="create-form__image">
                <p class="create-form__text">画像の追加</p>
                <label for="image">
                    <div id="drop-area" class="create-form__drop-area">
                        <p>クリックして写真を追加</p>
                        <p>またはドラッグアンドドロップ</p>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png" hidden>
                    </div>
                </label>
                <div id="image-preview" class="create-form__image-preview">
                    @if(isset($review) && $review->image_url)
                        <img src="{{ asset('storage/' . $review->image_url) }}" alt="現在の画像" style="max-width: 200px;">
                    @endif
                </div>
            </div>

            <button class="create-form__button" type="submit">{{ isset($review) ? '更新する' : '投稿する' }}</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/review.js') }}"></script>
<script src="{{ asset('js/favorite.js') }}"></script>

@endsection