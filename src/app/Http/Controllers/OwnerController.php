<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class OwnerController extends Controller
{
    public function showCreateShopForm()
    {
        $areas = Area::all();
        $genres = Genre::all();

        return view('owner.create', compact('areas', 'genres'));
    }

    public function createShop(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|integer|exists:areas,id',
            'genre_id' => 'required|integer|exists:genres,id',
            'description' => 'nullable|string',
            'image_url' => 'required|string|max:255',
        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('owner.createSuccess');
    }

    public function showUpdateShopForm()
    {
        $areas = Area::all();
        $genres = Genre::all();
        $shop = Auth::user()->shop;

        if (!$shop) {
            abort(404, 'Shop not found.');
        }

        return view('owner.update', compact('areas', 'genres', 'shop'));
    }

    public function updateShop(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|integer|exists:areas,id',
            'genre_id' => 'required|integer|exists:genres,id',
            'description' => 'nullable|string',
            'image_url' => 'required|string|max:255',
        ]);

        $shop = Auth::user()->shop;

        if (!$shop) {
            abort(404, 'Shop not found.');
        }

        $shop->update([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('owner.updateSuccess');
    }
    
    public function showCreateSuccess()
    {
        return view('owner.create-success');
    }

    public function showUpdateSuccess()
    {
        return view('owner.update-success');
    }

    public function reservations()
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            abort(404, 'Shop not found.');
        }

        $reservations = Reservation::where('shop_id', $shop->id)->get();
        return view('owner.reservations', compact('reservations'));
    }

    public function editEmail()
    {
        $emailSettings = [
            'subject' => session('mail_subject', 'お知らせ'),
            'content' => session('mail_content', 'これはテストメッセージです。')
        ];

        return view('owner.email', compact('emailSettings'));
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        session([
            'mail_subject' => $request->input('subject'),
            'mail_content' => $request->input('content')
        ]);

        return redirect()->route('owner.editEmail');
    }

    public function sendEmail(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $subject = session('mail_subject', 'お知らせ');
        $content = session('mail_content', 'これはテストメッセージです。');

        Mail::to($user->email)->send(new NotificationMail($subject, $content));

        return redirect()->route('owner.reservations');
    }

    public function sendEmailAll()
    {
        $users = User::all();

        $subject = session('mail_subject', 'お知らせ');
        $content = session('mail_content', 'これは一斉送信テストメッセージです。');

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationMail($subject, $content));
        }

        return redirect()->route('owner.reservations');
    }

}
