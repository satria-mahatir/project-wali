<x-app-layout>
    <div class="container py-4">
        
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fw-bold">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ================= VIEW GURU ================= --}}
        @if(auth()->user()->role == 'guru')
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-chat-left-text-fill me-2"></i>Manajemen Komunikasi</h5>
                    <ul class="nav nav-pills nav-fill bg-light rounded-pill p-1">
                        <li class="nav-item">
                            <button class="nav-link active rounded-pill fw-bold" data-bs-toggle="pill" data-bs-target="#perlu-balas">
                                <i class="bi bi-envelope-exclamation me-1"></i> Perlu Dibalas <span class="badge bg-danger ms-1">{{ $perlu_balas->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link rounded-pill fw-bold" data-bs-toggle="pill" data-bs-target="#sudah-balas">
                                <i class="bi bi-envelope-check me-1"></i> Riwayat Terbalas <span class="badge bg-secondary ms-1">{{ $sudah_balas->count() }}</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    {{-- TAB 1: PERLU DIBALAS --}}
                    <div class="tab-pane fade show active" id="perlu-balas">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @forelse($perlu_balas as $studentId => $chats)
                                        @php $last = $chats->first(); @endphp
                                        <tr data-bs-toggle="collapse" data-bs-target="#reply-{{ $studentId }}" style="cursor: pointer;" class="bg-danger bg-opacity-10 border-start border-danger border-4">
                                            <td class="ps-4 py-3 fw-bold">{{ $last->sender->name }}</td>
                                            <td><div class="fw-bold small">{{ $last->subject }}</div><small>{{ Str::limit($last->body, 50) }}</small></td>
                                            <td class="text-end pe-4 small text-danger">{{ $last->created_at->translatedFormat('H:i') }}</td>
                                        </tr>
                                        <tr class="collapse" id="reply-{{ $studentId }}"><td colspan="3" class="bg-light p-4">
                                            <div class="card border-0 shadow rounded-4 p-3 mx-auto" style="max-width: 800px;">
                                                <div class="mb-3 overflow-auto" style="max-height: 300px;">
                                                    @foreach($chats->reverse() as $chat)
                                                        <div class="mb-2 d-flex flex-column {{ $chat->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                                            <div class="p-2 px-3 rounded-4 {{ $chat->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white border shadow-sm' }} small">
                                                                {{ $chat->body }}
                                                            </div>
                                                            <small class="text-muted mt-1" style="font-size: 9px;">{{ $chat->created_at->translatedFormat('H:i') }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <form action="{{ route('chat.send') }}" method="POST" class="d-flex gap-2 border-top pt-3">
                                                    @csrf <input type="hidden" name="receiver_id" value="{{ $studentId }}">
                                                    <input type="hidden" name="subject" value="Re: {{ $last->subject }}">
                                                    <input type="text" name="body" class="form-control bg-light border-0" placeholder="Tambahkan pesan balasan..." required>
                                                    <button class="btn btn-primary px-4 fw-bold shadow-sm">Kirim</button>
                                                </form>
                                            </div>
                                        </td></tr>
                                    @empty
                                        <tr><td class="text-center py-5 text-muted">🎉 Semua murid sudah dijawab.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TAB 2: SUDAH DIBALAS --}}
                    <div class="tab-pane fade" id="sudah-balas">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @forelse($sudah_balas as $studentId => $chats)
                                        @php 
                                            $last = $chats->first(); 
                                            $student = $last->sender_id == auth()->id() ? $last->receiver : $last->sender;
                                        @endphp
                                        <tr data-bs-toggle="collapse" data-bs-target="#done-{{ $studentId }}" style="cursor: pointer;" class="border-start border-secondary border-4">
                                            <td class="ps-4 py-3 fw-bold">{{ $student->name }}</td>
                                            <td><div class="small fw-bold">Terakhir dikirim:</div><small class="text-muted">{{ Str::limit($last->body, 50) }}</small></td>
                                            <td class="text-end pe-4 small text-muted">Selesai {{ $last->created_at->translatedFormat('H:i') }}</td>
                                        </tr>
                                        <tr class="collapse" id="done-{{ $studentId }}"><td colspan="3" class="bg-light p-4">
                                            <div class="card border-0 shadow rounded-4 p-3 mx-auto" style="max-width: 800px;">
                                                <div class="mb-3 overflow-auto" style="max-height: 300px;">
                                                    @foreach($chats->reverse() as $chat)
                                                        <div class="mb-2 d-flex flex-column {{ $chat->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                                            <div class="p-2 px-3 rounded-4 {{ $chat->sender_id == auth()->id() ? 'bg-secondary text-white' : 'bg-white border' }} small">
                                                                {{ $chat->body }}
                                                            </div>
                                                            <small class="text-muted mt-1" style="font-size: 9px;">{{ $chat->created_at->translatedFormat('H:i') }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <form action="{{ route('chat.send') }}" method="POST" class="d-flex gap-2 border-top pt-3">
                                                    @csrf <input type="hidden" name="receiver_id" value="{{ $studentId }}">
                                                    <input type="hidden" name="subject" value="Re: {{ $last->subject }}">
                                                    <input type="text" name="body" class="form-control bg-light border-0" placeholder="Ingin menambahkan sesuatu?" required>
                                                    <button class="btn btn-secondary px-4 fw-bold shadow-sm">Kirim Tambahan</button>
                                                </form>
                                            </div>
                                        </td></tr>
                                    @empty
                                        <tr><td class="text-center py-5 text-muted">Belum ada riwayat surat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        {{-- ================= VIEW MURID ================= --}}
        @else
            <div class="row g-4">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">Kirim Surat Baru</h5>
                        <form action="{{ route('dashboard') }}" method="GET" class="mb-3 d-flex gap-2">
                            <input type="text" name="search_guru" class="form-control bg-light border-0 px-3 rounded-pill" placeholder="Cari guru..." value="{{ request('search_guru') }}">
                            <button class="btn btn-dark rounded-circle"><i class="bi bi-search"></i></button>
                        </form>
                        <form action="{{ route('chat.send') }}" method="POST">
                            @csrf
                            <select name="receiver_id" class="form-select bg-light border-0 mb-3 rounded-pill px-3" required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($gurus as $guru) <option value="{{ $guru->id }}">{{ $guru->name }}</option> @endforeach
                            </select>
                            <input type="text" name="subject" class="form-control bg-light border-0 mb-3 rounded-pill px-3" placeholder="Perihal" required>
                            <textarea name="body" class="form-control bg-light border-0 mb-3 rounded-4 p-3" rows="5" placeholder="Isi surat..." required></textarea>
                            <button class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">KIRIM SURAT</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <h5 class="fw-bold mb-4">Riwayat Saya</h5>
                        <div class="overflow-auto pe-2" style="max-height: 500px;">
                            @forelse ($myMessages as $msg)
                                <div class="mb-3 p-3 rounded-4 {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white ms-5 shadow-sm' : 'bg-light text-dark me-5 border' }}">
                                    <div class="d-flex justify-content-between small mb-1 opacity-75">
                                        <span class="fw-bold">{{ $msg->subject }}</span>
                                        <span>{{ $msg->created_at->translatedFormat('H:i') }}</span>
                                    </div>
                                    <p class="mb-0 small">{{ $msg->body }}</p>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">Belum ada riwayat surat.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>