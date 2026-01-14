<x-app-layout>
    <div class="container py-4">
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4 border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Dashboard {{ strtoupper(auth()->user()->role) }}</h2>
                            <p class="mb-0 opacity-75">Sistem Informasi Wali & Monitoring Chat</p>
                        </div>
                        <i class="bi bi-shield-check fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- --- LOGIKA ADMIN --- --}}
        @if(auth()->user()->role == 'admin')
            <div class="row g-4">
                
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-person-plus-fill me-2"></i>Registrasi Guru Wali</h5>
                            <form action="{{ route('admin.storeGuru') }}" method="POST" class="row g-3">
                                @csrf
                                <div class="col-md-3">
                                    <input type="text" name="name" class="form-control bg-light border-0 p-3 rounded-3" placeholder="Nama Guru" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="email" name="email" class="form-control bg-light border-0 p-3 rounded-3" placeholder="Email" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="password" name="password" class="form-control bg-light border-0 p-3 rounded-3" placeholder="Password" required>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3">Simpan Guru</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Daftar Guru & Aktivitas</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Nama Guru</th>
                                        <th>Email</th>
                                        <th>Total Chat</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gurus as $guru)
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">{{ $guru->name }}</td>
                                            <td>{{ $guru->email }}</td>
                                            <td>
                                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">
                                                    {{ \App\Models\Message::where('sender_id', $guru->id)->orWhere('receiver_id', $guru->id)->count() }} Pesan
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('dashboard', ['guru_id' => $guru->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1">
                                                    <i class="bi bi-eye"></i> Intip
                                                </a>
                                                <form action="{{ route('admin.destroyGuru', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus guru ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 p-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <h5 class="fw-bold mb-0">Monitoring Log Chat</h5>
                                </div>
                                <div class="col-md-8">
                                    <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2 justify-content-md-end">
                                        <select name="guru_id" class="form-select form-select-sm border-0 bg-light rounded-pill px-3" style="width: 200px;" onchange="this.form.submit()">
                                            <option value="">-- Semua Guru --</option>
                                            @foreach($gurus as $g)
                                                <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="search" class="form-control form-control-sm border-0 bg-light rounded-pill px-3" placeholder="Cari nama..." style="width: 180px;">
                                        <button type="submit" class="btn btn-sm btn-dark rounded-pill px-4">Filter</button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Reset</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-muted small">
                                    <tr>
                                        <th class="ps-4">Waktu</th>
                                        <th>Pengirim</th>
                                        <th>Penerima</th>
                                        <th>Pesan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allMessages as $msg)
                                        <tr>
                                            <td class="ps-4 small text-muted">{{ $msg->created_at->format('d/m H:i') }}</td>
                                            <td><span class="badge bg-{{ $msg->sender->role == 'guru' ? 'primary' : 'success' }}">{{ $msg->sender->name }}</span></td>
                                            <td class="fw-bold">{{ $msg->receiver->name }}</td>
                                            <td><div class="p-2 bg-light rounded-3 small border">{{ $msg->body }}</div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4">{{ $allMessages->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
                    </div>
                </div>
            </div>

        {{-- --- LOGIKA GURU & MURID (Tetap seperti sebelumnya) --- --}}
        @elseif(auth()->user()->role == 'guru')
            <div class="row g-4">
                <div class="col-lg-8 mx-auto">
                    <h5 class="fw-bold mb-4 text-primary">Pesan Masuk Murid</h5>
                    @foreach($messages as $msg)
                        <div class="card border-0 shadow-sm rounded-4 mb-3 p-4 border-start border-primary border-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">{{ $msg->sender->name }}</span>
                                <span class="small text-muted">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-muted mb-3">{{ $msg->body }}</p>
                            <form action="{{ route('chat.send') }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $msg->sender_id }}">
                                <input type="text" name="body" class="form-control bg-light border-0 rounded-4" placeholder="Balas..." required>
                                <button type="submit" class="btn btn-primary rounded-4">Kirim</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="row g-4">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-primary">Hubungi Guru Wali</h5>
                        <form action="{{ route('chat.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="receiver_id" class="form-select border-0 bg-light p-3" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach ($gurus as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <textarea name="body" class="form-control border-0 bg-light p-3 mb-3" rows="4" placeholder="Tulis pesan..." required></textarea>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">Riwayat Chat</h5>
                        <div class="overflow-auto" style="max-height: 450px;">
                            @foreach ($myMessages as $msg)
                                <div class="mb-3 d-flex flex-column {{ $msg->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                    <div class="p-3 rounded-4 {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 80%;">
                                        <div class="d-flex justify-content-between gap-3 mb-1">
                                            <span class="fw-bold" style="font-size: 10px;">{{ $msg->sender_id == auth()->id() ? 'SAYA' : $msg->sender->name }}</span>
                                            <span style="font-size: 9px opacity: 0.7;">{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <p class="mb-0 small">{{ $msg->body }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>