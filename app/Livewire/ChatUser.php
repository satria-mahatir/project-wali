<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ChatUser extends Component
{
    public $search_guru;

    public function render()
    {
        $user = auth()->user();

        // Data buat GURU
        $allMessages = Message::where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        $grouped = $allMessages->groupBy(fn ($msg) => $msg->sender_id == $user->id ? $msg->receiver_id : $msg->sender_id);

        $perlu_balas = $grouped->filter(fn ($chats) => $chats->first()->sender_id != $user->id);
        $sudah_balas = $grouped->filter(fn ($chats) => $chats->first()->sender_id == $user->id);

        // Data buat MURID
        $gurus = User::where('role', 'guru')
            ->when($this->search_guru, fn ($q) => $q->where('name', 'like', '%'.$this->search_guru.'%'))
            ->get();

        $myMessages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        return view('livewire.chat-user', compact('perlu_balas', 'sudah_balas', 'gurus', 'myMessages'));
    }
}
