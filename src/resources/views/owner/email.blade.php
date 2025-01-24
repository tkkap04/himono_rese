@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css')}}">
@endsection

@section('content')
    <div class="input">
        <div class="input-title">
            <h2 class="input-title__text">Edit Email</h2>
        </div>
        <form class="input-box" action="{{ route('owner.updateEmail') }}" method="post">
            @csrf
            <div class="input-box__item">
                <label for="subject">件名:</label>
                <input type="text" id="subject" name="subject" class="input-box__item-input" value="{{ old('subject', $emailSettings['subject']) }}" required>
            </div>
            <div class="input-box__item">
                <label for="content">内容:</label>
                <textarea id="content" name="content" class="input-box__item-text" required>{{ old('content', $emailSettings['content']) }}</textarea>
            </div>
            <button type="submit" class="input-box__item-submit-button">保存</button>
        </form>
    </div>
@endsection