<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->role == 'admin') {
            // Admin melihat semua pesan
            $data['allMessages'] = Message::with(['sender', 'receiver'])->latest()->get();
        } elseif ($user->role == 'guru') {
            // Guru melihat pesan yang ditujukan ke dia
            $data['messages'] = Message::where('receiver_id', $user->id)->with('sender')->latest()->get();
        } else {
            // Murid melihat daftar guru untuk dipilih dan pesan yang dia kirim
            $data['gurus'] = User::where('role', 'guru')->get();
            $data['myMessages'] = Message::where('sender_id', $user->id)->with('receiver')->latest()->get();
        }

        return view('dashboard', $data);
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['body' => 'required', 'receiver_id' => 'required']);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Pesan terkirim!');
    }
}