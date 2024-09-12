@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css')}}">
@endsection

@section('content')
<div class="input">
    <div class="input-title">
        <h2 class="input-title__text">Update Shop</h2>
    </div>

    <form class="input-box" action="{{ route('owner.updateShop') }}" method="post">
        @csrf
        @method('PUT')

        <div class="input-box__item__shopname">
            <label for="name">Shop Name</label>
            <input type="text" id="name" name="name" class="input-box__item-input" value="{{ $shop->name }}" required>
        </div>

        <div class="form-group">
            <label for="area_id">Area</label>
            <select id="area_id" name="area_id" class="input-box__item-input" required>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ $shop->area_id == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="genre_id">Genre</label>
            <select id="genre_id" name="genre_id" class="input-box__item-input" required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $shop->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="input-box__item-text">{{ $shop->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="image_url">Image URL</label>
            <input type="text" id="image_url" name="image_url" class="input-box__item-input" value="{{ $shop->image_url }}" required>
        </div>

        <div class="input-box__item-submit">
            <input type="submit" class="input-box__item-submit-button" value="更新">
        </div>
    </form>
</div>
@endsection
