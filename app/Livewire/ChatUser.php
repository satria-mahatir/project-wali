<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon; 

class ChatUser extends Component
{
    public $bulanAktif = ''; 
    public $activeTab = 'perlu-balas'; // INI KUNCI BIAR TAB GAK LOMPAT SENDIRI

    public function render()
    {
        $user = auth()->user();
        $availableMonths = []; 

        // ================= DATA BUAT GURU =================
        if ($user->role == 'guru') {
            $startDate = $user->created_at ? $user->created_at->startOfMonth() : now()->startOfMonth();
            $endDate = now()->startOfMonth(); 

            while ($startDate->lte($endDate)) {
                $availableMonths[$startDate->format('Y-m')] = $startDate->translatedFormat('F Y');
                $startDate->addMonth();
            }
            $availableMonths = array_reverse($availableMonths, true);
        }

        $queryGuru = Message::where(function($query) use ($user) {
            $query->where('receiver_id', $user->id)
                  ->orWhere('sender_id', $user->id);
        });

        if (!empty($this->bulanAktif)) {
            $pisahWaktu = explode('-', $this->bulanAktif);
            if (count($pisahWaktu) == 2) {
                $queryGuru->whereYear('created_at', $pisahWaktu[0])
                          ->whereMonth('created_at', $pisahWaktu[1]);
            }
        }

        $allMessages = $queryGuru->with(['sender', 'receiver'])->latest()->get();

        $grouped = $allMessages->groupBy(fn ($msg) => $msg->sender_id == $user->id ? $msg->receiver_id : $msg->sender_id);
        $perlu_balas = $grouped->filter(fn ($chats) => $chats->first()->sender_id != $user->id);
        $sudah_balas = $grouped->filter(fn ($chats) => $chats->first()->sender_id == $user->id);


        // ================= DATA BUAT MURID =================
        $myMessages = Message::where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        return view('livewire.chat-user', compact('perlu_balas', 'sudah_balas', 'myMessages', 'availableMonths'));
    }
}