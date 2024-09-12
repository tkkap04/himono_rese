<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="stripe-key" content="{{ config('services.stripe.key') }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css')}}"> 
    @yield('css')
</head>

<body>
<div class="app">
    <header class="header">
        <div class="header-left">
        <button id="openModalBtn" class="modal-btn">Rese</button>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close"> </span>
                    <div class="menu">
                        <a href="/" class="menu-item">Home</a>
                        @if(Auth::check())
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                                <button type="submit" class="menu-item__logout">Logout</button>
                            </form>
                            <a href="{{ route('mypage') }}" class="menu-item">Mypage</a>
                            <a href="{{ route('payment.show') }}" class="menu-item">Cacher</a>
                            @if(Auth::user()->role === 'owner')
                                <a href="{{ route('owner.create') }}" class="menu-item">Create Shop Information</a>
                                <a href="{{ route('owner.update') }}" class="menu-item">Update Shop Information</a>
                                <a href="{{ route('owner.reservations') }}" class="menu-item">Reservation Information</a>
                                <a href="{{ route('owner.editEmail') }}" class="menu-item">Edit Email</a>
                            @elseif(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.create') }}" class="menu-item">Create Owner</a>
                                <a href="{{ route('admin.list') }}" class="menu-item">User List</a>
                                <a href="{{ route('admin.editEmail') }}" class="menu-item">Edit Email</a>
                            @endif           
                        @else
                            <a href="{{ route('register') }}" class="menu-item">Registration</a>
                            <a href="{{ route('login') }}" class="menu-item">Login</a>
                        @endif
                    </div>
                </div>
            </div>
            <script src="{{ asset('js/menu.js') }}"></script>
        </div>
        <div class="header-right">
            @yield('header-right')
        </div>
    </header>

    <main class="content">
        @yield('content')
    </main>
</div>
</body>  
</html>    