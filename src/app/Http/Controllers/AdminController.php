<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function showCreateOwnerForm()
    {
        return view('admin.create');
    }

    public function createOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'owner',
        ]);

        return redirect()->route('admin.create');
    }

    public function showList()
    {
        $users = User::all();
        return view('admin.list', compact('users'));
    }

    public function editEmail()
    {
        $emailSettings = [
            'subject' => session('mail_subject', 'お知らせ'),
            'content' => session('mail_content', 'これはテストメッセージです。')
        ];

        return view('admin.email', compact('emailSettings'));
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

        return redirect()->route('admin.editEmail');
    }

    public function sendEmail(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $subject = session('mail_subject', 'お知らせ');
        $content = session('mail_content', 'これはテストメッセージです。');

        Mail::to($user->email)->send(new NotificationMail($subject, $content));

        return redirect()->route('admin.list');
    }

    public function sendEmailAll()
    {
        $users = User::all();

        $subject = session('mail_subject', 'お知らせ');
        $content = session('mail_content', 'これは一斉送信テストメッセージです。');

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationMail($subject, $content));
        }

        return redirect()->route('admin.list');
    }
}
