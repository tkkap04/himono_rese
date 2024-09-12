<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->with('shop')->get();
        $reservations = Reservation::where('user_id', $user->id)->with('shop')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc') 
            ->get();

        return view('mypage', compact('user', 'favorites', 'reservations'));
    }
}
