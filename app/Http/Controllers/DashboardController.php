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

        // Inisialisasi data kosong agar tidak error di Blade
        $data = [
            'allMessages' => collect(),
            'messages' => collect(),
            'myMessages' => collect(),
            'gurus' => collect(),
        ];

        if ($user->role == 'admin') {
            // Admin butuh daftar semua guru untuk statistik dan filter
            $data['gurus'] = User::where('role', 'guru')->get();
            
            $query = Message::with(['sender', 'receiver']);

            // FILTER: Berdasarkan Guru yang dipilih (Fitur Intip Chat)
            if ($request->filled('guru_id')) {
                $guruId = $request->guru_id;
                $query->where(function ($q) use ($guruId) {
                    $q->where('sender_id', $guruId)
                      ->orWhere('receiver_id', $guruId);
                });
            }

            // FILTER: Berdasarkan pencarian nama murid/guru
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('sender', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%$search%");
                    })->orWhereHas('receiver', function ($rq) use ($search) {
                        $rq->where('name', 'like', "%$search%");
                    });
                });
            }

            $data['allMessages'] = $query->latest()->paginate(20);

        } elseif ($user->role == 'guru') {
            $data['messages'] = Message::where('receiver_id', $user->id)
                ->with('sender')
                ->latest()
                ->get();

        } elseif ($user->role == 'murid') {
            $data['gurus'] = User::where('role', 'guru')->get();
            $data['myMessages'] = Message::where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id)
                ->with(['sender', 'receiver'])
                ->latest()
                ->get();
        }

        return view('dashboard', $data);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'receiver_id' => 'required',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'guru',
        ]);

        return back()->with('success', 'Guru baru berhasil ditambahkan!');
    }

    public function destroyGuru($id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->role == 'admin' && $user->role == 'guru') {
            $user->delete();
            return back()->with('success', 'Data guru berhasil dihapus!');
        }
        return back()->with('error', 'Akses ditolak.');
    }
}