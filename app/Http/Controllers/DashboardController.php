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

        // Inisialisasi semua variabel sebagai koleksi kosong agar Blade tidak error
        $data = [
            'allMessages' => collect(),
            'messages' => collect(),
            'myMessages' => collect(),
            'gurus' => collect(),
        ];

        if ($user->role == 'admin') {
            $query = Message::with(['sender', 'receiver']);

            if ($request->has('search')) {
                $search = $request->search;
                $query->whereHas('sender', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhereHas('receiver', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            }
            // Admin menggunakan paginate
            $data['allMessages'] = $query->latest()->paginate(20);

        } elseif ($user->role == 'guru') {
            // Guru mengambil pesan masuk
            $data['messages'] = Message::where('receiver_id', $user->id)
                ->with('sender')
                ->latest()
                ->get();

        } elseif ($user->role == 'murid') {
            // Murid mengambil daftar guru & riwayat chat
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

    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        // Opsional: Cek apakah yang hapus itu admin
        if (auth()->user()->role !== 'admin') {
            return back()->with('error', 'Hanya admin yang boleh hapus riwayat!');
        }

        $message->delete();

        return back()->with('success', 'Pesan berhasil dihapus!');
    }

    // Tambahkan di dalam class DashboardController

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'guru', // Langsung set jadi guru
        ]);

        return back()->with('success', 'Guru baru berhasil ditambahkan!');
    }
}
