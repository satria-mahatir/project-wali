<x-app-layout>
    <div class="container py-4">
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4 border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">Dashboard {{ strtoupper(auth()->user()->role) }}</h2>
                            <p class="mb-0 opacity-75">Sistem Komunikasi Terpadu Wali</p>
                        </div>
                        <i class="bi bi-person-workspace fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{--                BAGIAN ADMIN                --}}
        
        @if(auth()->user()->role == 'admin')
            <div class="row g-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-person-plus-fill me-2"></i>Registrasi Guru</h5>
                        <form action="{{ route('admin.storeGuru') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-3"><input type="text" name="name" class="form-control bg-light border-0 p-3" placeholder="Nama Guru" required></div>
                            <div class="col-md-3"><input type="email" name="email" class="form-control bg-light border-0 p-3" placeholder="Email" required></div>
                            <div class="col-md-3"><input type="password" name="password" class="form-control bg-light border-0 p-3" placeholder="Password" required></div>
                            <div class="col-md-3"><button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Simpan Guru</button></div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="fw-bold mb-0">Daftar Guru & Aktivitas</h5>
                        </div>
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light small text-uppercase">
                                <tr><th class="ps-4">Nama</th><th>Email</th><th>Aktivitas</th><th class="text-end pe-4">Aksi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($gurus as $guru)
                                    <tr>
                                        <td class="ps-4 fw-bold">{{ $guru->name }}</td>
                                        <td>{{ $guru->email }}</td>
                                        <td><span class="badge bg-info bg-opacity-10 text-info">{{ \App\Models\Message::where('sender_id', $guru->id)->orWhere('receiver_id', $guru->id)->count() }} Pesan</span></td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('dashboard', ['guru_id' => $guru->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="bi bi-eye"></i> Intip</a>
                                            <form action="{{ route('admin.destroyGuru', $guru->id) }}" method="POST" class="d-inline">@csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-trash"></i></button></form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 p-4 d-flex justify-content-between">
                            <h5 class="fw-bold mb-0">Log Monitoring</h5>
                            <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2">
                                <select name="guru_id" class="form-select form-select-sm bg-light border-0 rounded-pill" onchange="this.form.submit()">
                                    <option value="">-- Semua Guru --</option>
                                    @foreach($gurus as $g)<option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>@endforeach
                                </select>
                                <input type="text" name="search" class="form-control form-control-sm bg-light border-0 rounded-pill" placeholder="Cari..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-sm btn-dark rounded-pill px-4">Cari</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small">
                                    <tr><th class="ps-4">Waktu</th><th>Dari</th><th>Ke</th><th>Pesan</th></tr>
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
                        <div class="p-3">{{ $allMessages->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
                    </div>
                </div>
            </div>

        {{--                BAGIAN GURU                 --}}
        
        @elseif(auth()->user()->role == 'guru')
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="height: 600px;">
                <div class="row g-0 h-100">
                    <div class="col-md-4 border-end bg-white h-100 overflow-auto">
                        <div class="p-3 bg-light border-bottom font-weight-bold">Daftar Chat</div>
                        <div class="list-group list-group-flush">
                            @forelse($messages as $studentId => $chats)
                                @php 
                                    $student = $chats->first()->sender_id == auth()->id() ? $chats->first()->receiver : $chats->first()->sender;
                                @endphp
                                <a href="?student_id={{ $studentId }}" class="list-group-item list-group-item-action p-3 {{ request('student_id') == $studentId ? 'bg-primary bg-opacity-10 border-start border-primary border-4' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fw-bold text-dark small">{{ $student->name }}</div>
                                        <span class="text-muted" style="font-size: 10px;">{{ $chats->first()->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="text-muted small text-truncate">{{ $chats->first()->body }}</div>
                                </a>
                            @empty
                                <p class="text-center mt-5 text-muted">Belum ada chat.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-md-8 bg-light d-flex flex-column h-100">
                        @if(request('student_id'))
                            @php $activeChat = $messages[request('student_id')]; @endphp
                            <div class="p-3 bg-white border-bottom fw-bold">Chat dengan {{ \App\Models\User::find(request('student_id'))->name }}</div>
                            <div class="flex-grow-1 p-3 overflow-auto d-flex flex-column-reverse">
                                @foreach($activeChat as $chat)
                                    <div class="mb-3 d-flex flex-column {{ $chat->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                        <div class="p-2 px-3 rounded-4 {{ $chat->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white border' }}" style="max-width: 80%;">
                                            <p class="mb-0 small">{{ $chat->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="p-3 bg-white border-top">
                                <form action="{{ route('chat.send') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ request('student_id') }}">
                                    <input type="text" name="body" class="form-control rounded-pill bg-light border-0" placeholder="Ketik..." required>
                                    <button class="btn btn-primary rounded-circle"><i class="bi bi-send"></i></button>
                                </form>
                            </div>
                        @else
                            <div class="m-auto text-muted">Pilih murid untuk mulai chat.</div>
                        @endif
                    </div>
                </div>
            </div>

        {{--                BAGIAN MURID                --}}
        
        @else
            <div class="row g-4">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-primary">Kirim Pesan ke Guru</h5>
                        <form action="{{ route('chat.send') }}" method="POST">
                            @csrf
                            <select name="receiver_id" class="form-select bg-light border-0 mb-3 p-3" required>
                                <option value="">Pilih Guru</option>
                                @foreach ($gurus as $guru) <option value="{{ $guru->id }}">{{ $guru->name }}</option> @endforeach
                            </select>
                            <textarea name="body" class="form-control bg-light border-0 mb-3 p-3" rows="4" placeholder="Tulis pesan..." required></textarea>
                            <button class="btn btn-primary w-100 py-3 fw-bold rounded-3">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <h5 class="fw-bold mb-4">Riwayat Chat</h5>
                        <div class="overflow-auto" style="max-height: 450px;">
                            @foreach ($myMessages as $msg)
                                <div class="mb-3 d-flex flex-column {{ $msg->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                    <div class="p-3 rounded-4 {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 80%;">
                                        <div class="small fw-bold" style="font-size: 10px;">{{ $msg->sender_id == auth()->id() ? 'SAYA' : $msg->sender->name }}</div>
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