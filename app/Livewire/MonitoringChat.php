<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class MonitoringChat extends Component
{
    public $guruId;

    public $selectedGuru;

    public function mount($guruId)
    {
        $this->guruId = $guruId;
        $this->selectedGuru = User::find($guruId);
    }

    public function render()
    {
        // Ambil pesan terbaru dan kelompokkan berdasarkan lawan bicara (Murid)
        $allMessages = Message::with(['sender', 'receiver'])
            ->where(function ($q) {
                $q->where('sender_id', $this->guruId)
                    ->orWhere('receiver_id', $this->guruId);
            })
            ->latest()
            ->get()
            ->groupBy(fn ($msg) => $msg->sender_id == $this->guruId ? $msg->receiver_id : $msg->sender_id);

        return view('livewire.monitoring-chat', [
            'allMessages' => $allMessages,
        ]);
    }
}
