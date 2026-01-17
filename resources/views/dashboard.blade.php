<x-app-layout>
    <div class="container py-4">
        
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fw-bold">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ================= VIEW ADMIN ================= --}}
        @if(auth()->user()->role == 'admin')
            <div class="row g-3 mb-4 text-white">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-primary">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people-fill fs-1 opacity-50 me-3"></i>
                            <div><h3 class="fw-bold mb-0">{{ $stats['total_guru'] }}</h3><small>Total Guru</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-success">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-mortarboard-fill fs-1 opacity-50 me-3"></i>
                            <div><h3 class="fw-bold mb-0">{{ $stats['total_murid'] }}</h3><small>Total Murid</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-dark">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope-paper-fill fs-1 opacity-50 me-3"></i>
                            <div><h3 class="fw-bold mb-0">{{ $stats['total_surat'] }}</h3><small>Total Surat</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h6 class="fw-bold mb-3">Registrasi Guru</h6>
                        <form action="{{ route('admin.storeGuru') }}" method="POST">
                            @csrf
                            <input type="text" name="name" class="form-control bg-light border-0 mb-2" placeholder="Nama Guru" required>
                            <input type="email" name="email" class="form-control bg-light border-0 mb-2" placeholder="Email" required>
                            <input type="password" name="password" class="form-control bg-light border-0 mb-3" placeholder="Password" required>
                            <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3 shadow-sm">Simpan</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <h6 class="fw-bold mb-3">Arsip Guru Wali</h6>
                        <div class="row g-2 overflow-auto" style="max-height: 250px;">
                            @foreach($gurus as $guru)
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-4 d-flex align-items-center justify-content-between bg-white shadow-sm">
                                        <div class="text-truncate" style="max-width: 120px;">
                                            <div class="fw-bold small">{{ $guru->name }}</div>
                                            <small class="text-muted" style="font-size: 10px;">{{ $guru->email }}</small>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="?view_guru={{ $guru->id }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">Intip</a>
                                            <form action="{{ route('admin.destroyGuru', $guru->id) }}" method="POST">@csrf @method('DELETE')
                                                <button class="btn btn-sm text-danger" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if($selectedGuru)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-top border-primary border-4">
                        <div class="card-header bg-white p-4 border-0 d-flex justify-content-between">
                            <h5 class="fw-bold mb-0">Log Surat: {{ $selectedGuru->name }}</h5>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary rounded-pill px-3">Tutup</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 small">
                                <thead class="bg-light"><tr><th class="ps-4">Waktu</th><th>Pengirim</th><th>Penerima</th><th>Isi Pesan</th></tr></thead>
                                <tbody>
                                    @foreach($allMessages as $msg)
                                        <tr>
                                            <td class="ps-4">{{ $msg->created_at->format('d/m H:i') }}</td>
                                            <td><span class="badge bg-{{ $msg->sender->role == 'guru' ? 'primary' : 'success' }}">{{ $msg->sender->name }}</span></td>
                                            <td>{{ $msg->receiver->name }}</td>
                                            <td><strong>{{ $msg->subject }}</strong> - {{ Str::limit($msg->body, 60) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        {{-- ================= VIEW GURU ================= --}}
        
        @elseif(auth()->user()->role == 'guru')
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
                    <div class="tab-pane fade show active" id="perlu-balas">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @forelse($perlu_balas as $studentId => $chats)
                                        @php $last = $chats->first(); @endphp
                                        <tr data-bs-toggle="collapse" data-bs-target="#reply-{{ $studentId }}" style="cursor: pointer;" class="bg-danger bg-opacity-10 border-start border-danger border-4">
                                            <td class="ps-4 py-3 fw-bold">{{ $last->sender->name }}</td>
                                            <td><div class="fw-bold small">{{ $last->subject }}</div><small>{{ Str::limit($last->body, 50) }}</small></td>
                                            <td class="text-end pe-4 small text-danger">{{ $last->created_at->diffForHumans() }}</td>
                                        </tr>
                                        <tr class="collapse" id="reply-{{ $studentId }}"><td colspan="3" class="bg-light p-4">
                                            <div class="card border-0 shadow rounded-4 p-3 mx-auto" style="max-width: 800px;">
                                                <div class="mb-3 overflow-auto" style="max-height: 300px;">
                                                    @foreach($chats->reverse() as $chat)
                                                        <div class="mb-2 d-flex flex-column {{ $chat->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                                            <div class="p-2 px-3 rounded-4 {{ $chat->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white border shadow-sm' }} small">
                                                                {{ $chat->body }}
                                                            </div>
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

                    <div class="tab-pane fade" id="sudah-balas">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @forelse($sudah_balas as $studentId => $chats)
                                        @php $last = $chats->first(); $student = $last->sender_id == auth()->id() ? $last->receiver : $last->sender; @endphp
                                        <tr data-bs-toggle="collapse" data-bs-target="#done-{{ $studentId }}" style="cursor: pointer;">
                                            <td class="ps-4 py-3 fw-bold">{{ $student->name }}</td>
                                            <td><div class="small fw-bold">Terakhir dikirim:</div><small class="text-muted">{{ Str::limit($last->body, 50) }}</small></td>
                                            <td class="text-end pe-4 small text-muted">Selesai {{ $last->created_at->format('d/m H:i') }}</td>
                                        </tr>
                                        <tr class="collapse" id="done-{{ $studentId }}"><td colspan="3" class="bg-light p-4">
                                            <div class="card border-0 shadow rounded-4 p-3 mx-auto" style="max-width: 800px;">
                                                <div class="mb-3 overflow-auto" style="max-height: 300px;">
                                                    @foreach($chats->reverse() as $chat)
                                                        <div class="mb-2 d-flex flex-column {{ $chat->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                                            <div class="p-2 px-3 rounded-4 {{ $chat->sender_id == auth()->id() ? 'bg-secondary text-white' : 'bg-white border' }} small">
                                                                {{ $chat->body }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <form action="{{ route('chat.send') }}" method="POST" class="d-flex gap-2 border-top pt-3">
                                                    @csrf <input type="hidden" name="receiver_id" value="{{ $studentId }}">
                                                    <input type="hidden" name="subject" value="Re: {{ $chats->first()->subject }}">
                                                    <input type="text" name="body" class="form-control bg-light border-0" placeholder="Ingin menambahkan sesuatu?" required>
                                                    <button class="btn btn-secondary px-4 fw-bold">Kirim Tambahan</button>
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
                            <input type="text" name="search_guru" class="form-control bg-light border-0" placeholder="Cari guru..." value="{{ request('search_guru') }}">
                            <button class="btn btn-dark"><i class="bi bi-search"></i></button>
                        </form>
                        <form action="{{ route('chat.send') }}" method="POST">
                            @csrf
                            <select name="receiver_id" class="form-select bg-light border-0 mb-3" required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($gurus as $guru) <option value="{{ $guru->id }}">{{ $guru->name }}</option> @endforeach
                            </select>
                            <input type="text" name="subject" class="form-control bg-light border-0 mb-3" placeholder="Perihal" required>
                            <textarea name="body" class="form-control bg-light border-0 mb-3" rows="5" placeholder="Isi surat..." required></textarea>
                            <button class="btn btn-primary w-100 py-3 fw-bold rounded-3">KIRIM SURAT</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <h5 class="fw-bold mb-4">Riwayat Saya</h5>
                        <div class="overflow-auto pe-2" style="max-height: 500px;">
                            @foreach ($myMessages as $msg)
                                <div class="mb-3 p-3 rounded-4 {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white ms-5 shadow-sm' : 'bg-light text-dark me-5 border' }}">
                                    <div class="d-flex justify-content-between small mb-1 opacity-75">
                                        <span class="fw-bold">{{ $msg->subject }}</span>
                                        <span>{{ $msg->created_at->format('H:i') }}</span>
                                    </div>
                                    <p class="mb-0 small">{{ $msg->body }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>