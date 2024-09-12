@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservations.css')}}">
@endsection

@section('content')
    <div class="container">
        <p class="container-title">Reservation List</p>
        <form action="{{ route('owner.sendEmailAll') }}" method="post">
            @csrf
            <button type="submit" class="container-sendall">メール一斉送信</button>
        </form>
        <table class="reservation-table">
            <thead class="reservation-table-thead">
                <tr class="reservation-table-row">
                    <th class="reservation-table-head">Date</th>
                    <th class="reservation-table-head">Time</th>
                    <th class="reservation-table-head">Name</th>
                    <th class="reservation-table-head">Number of People</th>
                    <th class="reservation-table-head">Send E-mail</th>
                </tr>
            </thead>
            <tbody class="reservation-table-tbody">
                @forelse($reservations as $reservation)
                    <tr class="reservation-table-row">
                        <td class="reservation-table-description">{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}</td>
                        <td class="reservation-table-description">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
                        <td class="reservation-table-description">{{ $reservation->user->name }}</td>
                        <td class="reservation-table-description">{{ $reservation->number_of_people }}</td>
                        <td class="reservation-table-description">
                            <form action="{{ route('owner.sendEmail', $reservation->user) }}" method="post" class="container-send__form">
                                @csrf
                                <button type="submit" class="container-send">メール送信</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">予約情報がありません</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection