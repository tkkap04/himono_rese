@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('header-left')
<div class="header-sort">
    <form class="header-sort__form" action="{{ route('shops.index') }}" method="GET">
        <select class="header-sort__form-select" name="sort" id="sort" onchange="this.form.submit()">
            <option value="" disabled {{ request('sort') ? '' : 'selected' }}>並び替え：評価高/低</option>
            <option value="random" {{ request('sort') === 'random' ? 'selected' : '' }}>ランダム</option>
            <option value="high_rating" {{ request('sort') === 'high_rating' ? 'selected' : '' }}>評価が高い順</option>
            <option value="low_rating" {{ request('sort') === 'low_rating' ? 'selected' : '' }}>評価が低い順</option>
        </select>
    </form>
</div>
@endsection

@section('header-right')
<div class="header-search">
    <form class="header-search__form" action="{{ route('shops.index') }}" method="GET">
        <select name="area" id="area">
            <option value="">All area</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
        </select>
        <select name="genre" id="genre">
            <option value="">All genre</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>
            <input type="text" name="search" placeholder="Search..." value="{{ request()->get('search') }}">
            <button type="submit">Search</button>
    </form>
</div>
<div class="header-search__criteria">
    <p class="header-search__criteria-title">検索条件</p>
    <div class="header-search__criteria-box">
        @if(!empty($searchParams['area']))
            <p class="header-search__criteria-item">Area: {{ $searchParams['area'] }}</p>
        @endif
        @if(!empty($searchParams['genre']))
            <p class="header-search__criteria-item">Genre: {{ $searchParams['genre'] }}</p>
        @endif
        @if(!empty($searchParams['search']))
            <p class="header-search__criteria-item">Keyword: {{ $searchParams['search'] }}</p>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="shop-list">
    @foreach($shops as $shop)
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
    @endforeach
</div>

<script src="{{ asset('js/favorite.js') }}"></script>

@endsection