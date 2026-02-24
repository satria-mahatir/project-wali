<div wire:poll.2s>
    <div class="row no-gutters" style="min-height: 500px;">
        {{-- SIDEBAR LIST MURID --}}
        <div class="col-md-4 border-right bg-light" style="max-height: 550px; overflow-y: auto;">
            <div class="p-3 border-bottom bg-white sticky-top">
                <h6 class="mb-0 text-bold text-muted small text-uppercase">Daftar Lawan Bicara</h6>
            </div>
            <div class="nav flex-column nav-pills" id="chat-tabs" role="tablist">
                @forelse($allMessages as $opponentId => $chats)
                    @php
                        $opponent =
                            $chats->first()->sender_id == $guruId ? $chats->first()->receiver : $chats->first()->sender;
                        $lastMsg = $chats->first();
                    @endphp
                    <a class="nav-link chat-list-item border-bottom rounded-0 p-3" data-toggle="pill"
                        href="#chat-murid-{{ $opponentId }}" role="tab">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-bold text-dark">{{ $opponent->name ?? 'User' }}</span>
                            <small class="text-muted">{{ $lastMsg->created_at->format('H:i') }}</small>
                        </div>
                        <div class="text-truncate small text-muted text-left">{{ $lastMsg->body }}</div>
                    </a>
                @empty
                    <div class="p-5 text-center text-muted">Belum ada riwayat chat.</div>
                @endforelse
            </div>
        </div>

        {{-- PANEL ISI CHAT --}}
        <div class="col-md-8 bg-white chat-box">
            <div class="tab-content">
                {{-- Tampilan Default --}}
                <div class="tab-pane fade show active text-center py-5 mt-5">
                    <i class="fas fa-comments fa-5x text-gray-200 mb-4"></i>
                    <h5 class="text-muted">Pilih nama murid di sebelah kiri</h5>
                    <p class="text-muted px-5 small">Live Monitoring Active (2s)</p>
                </div>

                @foreach ($allMessages as $opponentId => $chats)
                    <div class="tab-pane fade" id="chat-murid-{{ $opponentId }}" wire:ignore.self role="tabpanel">
                        <div class="p-3 border-bottom bg-white sticky-top shadow-sm d-flex align-items-center">
                            <div class="bg-primary rounded-circle mr-3 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                            <div class="text-left">
                                <span class="text-bold d-block">Chat dengan:
                                    {{ $chats->first()->sender_id == $guruId ? $chats->first()->receiver->name ?? 'User' : $chats->first()->sender->name ?? 'User' }}</span>
                                <small class="text-success"><i class="fas fa-circle mr-1" style="font-size: 8px;"></i>
                                    Terhubung</small>
                            </div>
                        </div>
                        <div class="p-4"
                            style="height: 430px; overflow-y: auto; background-color: rgba(244, 246, 249, 0.9);">
                            @foreach ($chats->reverse() as $chat)
                                <div
                                    class="d-flex flex-column mb-3 {{ $chat->sender_id == $guruId ? 'align-items-end' : 'align-items-start' }}">
                                    <div class="p-2 px-3 rounded-xl shadow-sm {{ $chat->sender_id == $guruId ? 'bg-primary text-white' : 'bg-white text-dark border' }}"
                                        style="max-width: 80%;">
                                        <small class="text-bold d-block mb-1" style="font-size: 0.65rem; opacity: 0.7;">
                                            {{ $chat->sender_id == $guruId ? 'GURU WALI' : 'MURID' }}
                                        </small>
                                        {{ $chat->body }}
                                    </div>
                                    <small class="text-muted mt-1 px-2"
                                        style="font-size: 10px;">{{ $chat->created_at->format('d M, H:i') }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
