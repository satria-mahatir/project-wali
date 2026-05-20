<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Imports\MuridImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $data = [
            'stats' => $this->getAdminStats(),
            'display_data' => collect(),
            'selectedGuru' => null,
            'muridAsuhan' => collect(), // Variabel baru buat nampung anak asuh
            'gurus' => User::where('role', 'guru')->get(),
            'murids' => User::where('role', 'murid')->with('guruWali')->latest()->get(),
        ];

        if ($user->role == 'admin') {
            if ($request->view == 'guru') {
                $data['display_data'] = $data['gurus'];
            } elseif ($request->view == 'murid') {
                $data['display_data'] = $data['murids'];
            } elseif ($request->view == 'surat') {
                $data['display_data'] = User::where('role', 'guru')
                    ->withCount(['sentMessages', 'receivedMessages'])
                    ->get();
            }

            // LOGIKA BARU: Buat nampilin daftar murid asuhan guru tertentu
            if ($request->filled('lihat_murid')) {
                $data['selectedGuru'] = User::find($request->lihat_murid);
                $data['muridAsuhan'] = User::where('role', 'murid')
                    ->where('guru_id', $request->lihat_murid)
                    ->get();
            }
            return view('admin.dashboard', $data);

        } elseif ($user->role == 'guru') {
            $allMessages = Message::where('receiver_id', $user->id)->orWhere('sender_id', $user->id)->latest()->get();
            $grouped = $allMessages->groupBy(fn ($msg) => $msg->sender_id == $user->id ? $msg->receiver_id : $msg->sender_id);
            $data['perlu_balas'] = $grouped->filter(fn ($chats) => $chats->first()->sender_id != $user->id);
            $data['sudah_balas'] = $grouped->filter(fn ($chats) => $chats->first()->sender_id == $user->id);
            return view('dashboard', $data);

        } else {
            $data['myMessages'] = Message::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->latest()->get();
            return view('dashboard', $data);
        }
    }

    // --- MANAJEMEN MURID & IMPORT ---
    public function importMurid(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);
        Excel::import(new MuridImport, $request->file('file_excel'));
        return back()->with('success', 'Data murid berhasil di-import dan dijodohkan otomatis dengan guru walinya!');
    }

    public function storeMurid(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|numeric|unique:users,username',
            'guru_id' => 'required|exists:users,id', 
        ]);

        $emailOtomatis = strtolower(str_replace(' ', '', $request->name)) . '@siswa.com';
        if (User::where('email', $emailOtomatis)->exists()) {
            $emailOtomatis = strtolower(str_replace(' ', '', $request->name)) . rand(10,99) . '@siswa.com';
        }

        User::create([
            'name' => $request->name, 'email' => $emailOtomatis, 'username' => $request->nisn,
            'password' => Hash::make('12345678'), 'role' => 'murid', 'guru_id' => $request->guru_id, 
        ]);
        return back()->with('success', 'Murid berhasil ditambahkan!');
    }

    public function destroyMurid($id) {
        User::where('id', $id)->where('role', 'murid')->delete();
        return back()->with('success', 'Data murid dihapus.');
    }

    // --- MANAJEMEN GURU ---
    public function indexGuru() {
        if (auth()->user()->role != 'admin') return abort(403);
        return view('admin.guru', ['gurus' => User::where('role', 'guru')->latest()->get(), 'stats' => $this->getAdminStats()]);
    }

    public function storeGuru(Request $request) {
        $request->validate(['name' => 'required', 'email' => 'required|unique:users', 'password' => 'required|min:8']);
        User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'role' => 'guru']);
        return back()->with('success', 'Guru berhasil ditambahkan!');
    }

    public function destroyGuru($id) {
        User::where('id', $id)->where('role', 'guru')->delete();
        return back()->with('success', 'Guru berhasil dihapus.');
    }

    // --- PROFIL SAYA ---
    public function profile() {
        return view('admin.profile', ['stats' => $this->getAdminStats()]);
    }

    // --- STATISTIK & KIRIM PESAN ---
    private function getAdminStats() {
        return [
            'total_guru' => User::where('role', 'guru')->count(),
            'total_murid' => User::where('role', 'murid')->count(),
            'total_surat' => Message::count(),
        ];
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['receiver_id' => 'required|exists:users,id', 'subject' => 'required|string|max:255', 'body' => 'required|string']);
        Message::create(['sender_id' => auth()->id(), 'receiver_id' => $request->receiver_id, 'subject' => $request->subject, 'body' => $request->body]);
        return back()->with('success', 'Surat berhasil dikirim!');
    }
}