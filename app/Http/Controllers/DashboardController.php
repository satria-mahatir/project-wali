<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
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
            'allMessages' => collect(),
            'selectedGuru' => null,
            'gurus' => collect(),
            'myMessages' => collect(),
            'perlu_balas' => collect(),
            'sudah_balas' => collect(),
        ];

        if ($user->role == 'admin') {
            $data['gurus'] = User::where('role', 'guru')->get();
            $data['murids'] = User::where('role', 'murid')->get();

            if ($request->view == 'guru') {
                $data['display_data'] = $data['gurus'];
            } elseif ($request->view == 'murid') {
                $data['display_data'] = $data['murids'];
            } elseif ($request->view == 'surat') {
                $data['display_data'] = User::where('role', 'guru')->withCount(['receivedMessages as total_pesan'])->get();
            }

            if ($request->filled('view_guru')) {
                $data['selectedGuru'] = User::find($request->view_guru);
                $guruId = $request->view_guru;
                $data['allMessages'] = Message::with(['sender', 'receiver'])
                    ->where(function ($q) use ($guruId) {
                        $q->where('sender_id', $guruId)->orWhere('receiver_id', $guruId);
                    })->latest()->get()
                    ->groupBy(fn ($msg) => $msg->sender_id == $guruId ? $msg->receiver_id : $msg->sender_id);
            }

            return view('admin.dashboard', $data);

        } elseif ($user->role == 'guru') {
            $allMessages = Message::where('receiver_id', $user->id)->orWhere('sender_id', $user->id)->latest()->get();
            $grouped = $allMessages->groupBy(fn ($msg) => $msg->sender_id == $user->id ? $msg->receiver_id : $msg->sender_id);
            $data['perlu_balas'] = $grouped->filter(fn ($chats) => $chats->first()->sender_id != $user->id);
            $data['sudah_balas'] = $grouped->filter(fn ($chats) => $chats->first()->sender_id == $user->id);

            return view('dashboard', $data);

        } else { // Murid
            $data['gurus'] = User::where('role', 'guru')->get();
            $data['myMessages'] = Message::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->latest()->get();

            return view('dashboard', $data);
        }
    }

    // --- FITUR PROFIL ADMIN ---
    public function profile()
    {
        // Panggil stats admin biar di sidebar atau widget profil datanya akurat
        return view('admin.profile', ['stats' => $this->getAdminStats()]);
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // --- FITUR CHAT ---
    public function sendMessage(Request $request)
    {
        $request->validate(['receiver_id' => 'required', 'subject' => 'required', 'body' => 'required']);
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'Pesan terkirim!');
    }

    public function destroy($id)
    {
        Message::where(function ($q) use ($id) {
            $q->where('id', $id)->where('sender_id', auth()->id());
        })->delete();

        return redirect()->back()->with('success', 'Pesan dihapus.');
    }

    // --- MANAJEMEN GURU (ADMIN) ---
    public function indexGuru()
    {
        if (auth()->user()->role != 'admin') {
            return abort(403);
        }

        return view('admin.guru', ['gurus' => User::where('role', 'guru')->latest()->get(), 'stats' => $this->getAdminStats()]);
    }

    public function storeGuru(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|unique:users', 'password' => 'required|min:8']);
        User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'role' => 'guru']);

        return redirect()->back()->with('success', 'Guru berhasil ditambahkan!');
    }

    public function destroyGuru($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Guru berhasil dihapus.');
    }

    private function getAdminStats()
    {
        return [
            'total_guru' => User::where('role', 'guru')->count(),
            'total_murid' => User::where('role', 'murid')->count(),
            'total_surat' => Message::count(),
        ];
    }
}
