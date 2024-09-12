@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservations.css')}}">
@endsection

@section('content')
    <div class="container">
        <h2 class="container-title">User List</h2>
        <form action="{{ route('admin.sendEmailAll') }}" method="post">
            @csrf
            <button type="submit" class="container-sendall">メール一斉送信</button>
        </form>
        <table class="reservation-table">
            <thead class="reservation-table-thead">
                <tr class="reservation-table-row">
                    <th class="reservation-table-head">Name</th>
                    <th class="reservation-table-head">E-mail</th>
                    <th class="reservation-table-head">Send E-mail</th>
                </tr>
            </thead>
            <tbody class="reservation-table-tbody">
                @foreach($users as $user)
                <tr class="reservation-table-row">
                    <td class="reservation-table-description">{{ $user->name }}</td>
                    <td class="reservation-table-description">{{ $user->email }}</td>
                    <td class="reservation-table-description">
                        <form action="{{ route('admin.sendEmail', $user) }}" method="post" class="container-send__form">
                            @csrf
                            <button type="submit" class="container-send">メール送信</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection