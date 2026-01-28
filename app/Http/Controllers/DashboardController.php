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
        
        // Inisialisasi data default agar tidak ada variabel yang undefined
        $data = [
            'allMessages' => collect(),
            'gurus' => collect(),
            'murids' => collect(), // Harus ada di sini
            'perlu_balas' => collect(),
            'sudah_balas' => collect(),
            'myMessages' => collect(),
            'selectedGuru' => null,
            'stats' => [],
        ];

        // LOGIKA ADMIN (Dashboard Utama)
        if ($user->role == 'admin') {
            $data['stats'] = $this->getAdminStats();
            
            // Selalu tarik data guru dan murid untuk dashboard admin
            $data['gurus'] = User::where('role', 'guru')->get();
            $data['murids'] = User::where('role', 'murid')->latest()->get();

            // Logika khusus "Intip Surat" Guru
            if ($request->filled('view_guru')) {
                $data['selectedGuru'] = User::find($request->view_guru);
                $guruId = $request->view_guru;
                $data['allMessages'] = Message::with(['sender', 'receiver'])
                    ->where(function ($q) use ($guruId) {
                        $q->where('sender_id', $guruId)->orWhere('receiver_id', $guruId);
                    })->latest()->paginate(15);
            }

            return view('admin.dashboard', $data);

        // LOGIKA GURU
        } elseif ($user->role == 'guru') {
            $allMessages = Message::where('receiver_id', $user->id)
                ->orWhere('sender_id', $user->id)
                ->with(['sender', 'receiver'])
                ->latest()->get();

            $grouped = $allMessages->groupBy(function ($msg) use ($user) {
                return $msg->sender_id == $user->id ? $msg->receiver_id : $msg->sender_id;
            });

            $data['perlu_balas'] = $grouped->filter(fn ($chats) => $chats->first()->sender_id != $user->id);
            $data['sudah_balas'] = $grouped->filter(fn ($chats) => $chats->first()->sender_id == $user->id);

        // LOGIKA MURID
        } elseif ($user->role == 'murid') {
            $guruQuery = User::where('role', 'guru');
            if ($request->filled('search_guru')) {
                $guruQuery->where('name', 'like', '%'.$request->search_guru.'%');
            }
            $data['gurus'] = $guruQuery->get();
            $data['myMessages'] = Message::where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id)
                ->with(['sender', 'receiver'])
                ->latest()->get();
        }

        return view('dashboard', $data);
    }

    // HALAMAN KHUSUS DATA GURU (Admin Only)
    public function indexGuru()
    {
        if (auth()->user()->role != 'admin') {
            return abort(403);
        }

        $data = [
            'stats' => $this->getAdminStats(),
            'gurus' => User::where('role', 'guru')->latest()->get(),
            'murids' => collect(), // Tambahkan koleksi kosong biar file layout admin gak error
        ];

        return view('admin.guru', $data);
    }

    // Helper untuk ambil statistik
    private function getAdminStats()
    {
        return [
            'total_guru' => User::where('role', 'guru')->count(),
            'total_murid' => User::where('role', 'murid')->count(),
            'total_surat' => Message::count(),
        ];
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:150',
            'body' => 'required',
            'receiver_id' => 'required',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject ?? 'Lanjutan Pesan',
            'body' => $request->body,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'guru',
        ]);

        return back()->with('success', 'Guru baru berhasil didaftarkan!');
    }

    public function destroyGuru($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== 'guru') {
            return back()->with('error', 'Hanya akun guru yang bisa dihapus lewat sini.');
        }

        $user->delete();
        return back()->with('success', 'Data guru telah dihapus dari sistem.');
    }
}