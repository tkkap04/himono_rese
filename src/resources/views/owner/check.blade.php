@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/registlogin.css')}}">
@endsection

@section('content')
<div class="container">
    <h1>Reservations</h1>

    @if ($reservations->isEmpty())
        <p>No reservations found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Number of People</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->date }}</td>
                        <td>{{ $reservation->time }}</td>
                        <td>{{ $reservation->number_of_people }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
