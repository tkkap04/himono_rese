<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationEmail;


class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        $reservation = new Reservation();
        $reservation->user_id = auth()->id();
        $reservation->shop_id = $request->shop_id;
        $reservation->date = Carbon::parse($request->date);
        $reservation->time = $request->time;
        $reservation->number_of_people = $request->number_of_people;
        $reservation->save();

        $qrCodeSize = 500;
        $qrCodePath = storage_path('app/public/qrcodes/' . $reservation->id . '.png');
        QrCode::format('png')->generate(route('reservations', $reservation->id), $qrCodePath);

        Mail::to($reservation->user->email)->send(new ReservationEmail($reservation, $qrCodePath));

        return redirect()->route('reservations.done');
    }

    public function done()
    {
        return view('done');
    }

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'number_of_people' => 'required|integer|min:1|max:99',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->number_of_people = $request->number_of_people;
        $reservation->save();

        return response()->json([
            'success' => true,
            'reservation' => $reservation
        ]);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('mypage');
    }

    public function verifyQrCode(Request $request)
    {
        $reservation = Reservation::find($request->reservation_id);

        if ($reservation) {
            return response()->json(['status' => 'success', 'message' => 'Reservation verified successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Reservation not found.']);
        }
    }

}
