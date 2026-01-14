<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $data = [];

    if ($user->role == 'admin') {
        // Tambahkan fitur filter berdasarkan nama pengirim atau penerima
        $query = Message::with(['sender', 'receiver']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('sender', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('receiver', function($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $data['allMessages'] = $query->latest()->paginate(20); // Pake paginate biar gak berat
    } elseif ($user->role == 'guru') {
        $data['messages'] = Message::where('receiver_id', $user->id)->with('sender')->latest()->get();
    } else {
        $data['gurus'] = User::where('role', 'guru')->get();
        $data['myMessages'] = Message::where('sender_id', $user->id)
                                    ->orWhere('receiver_id', $user->id)
                                    ->with(['sender', 'receiver'])->latest()->get();
    }

    return view('dashboard', $data);
}
    public function sendMessage(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'receiver_id' => 'required'
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}