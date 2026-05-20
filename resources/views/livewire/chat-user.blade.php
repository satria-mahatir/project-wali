<div wire:poll.3s>
    <style>
        /* ========================================================
           UI 2026 CLEAN DESIGN - CHAT SYSTEM & BUTTONS
           ======================================================== */
        :root { 
            --primary-soft: #4f46e5; 
            --primary-gradient: linear-gradient(135deg, #4f46e5, #3b82f6);
            --bg-card: #ffffff; 
            --border-soft: #e2e8f0; 
            --text-muted: #64748b;
            --chat-bg-murid: #f8fafc;
            --chat-border: #e2e8f0;
        }

        .rounded-2xl { border-radius: 1.25rem !important; }
        
        .clean-card { 
            background-color: var(--bg-card) !important; 
            border: 1px solid var(--border-soft) !important; 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025) !important; 
        }
        .clean-header { 
            background-color: transparent !important; 
            border-bottom: 1px solid var(--border-soft) !important; 
        }

        /* --------------------------------------------------------
           TOMBOL 2026 (GLOW, OUTLINE, SELECT CUSTOM)
           -------------------------------------------------------- */
        .btn-modern { 
            font-weight: 600; 
            padding: 0.6rem 1.5rem; 
            letter-spacing: 0.3px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            border: none; 
            border-radius: 50rem !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Tombol Utama (Kirim) dengan efek Glow */
        .btn-primary-glow {
            background: var(--primary-gradient);
            color: white !important;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3) !important;
        }
        .btn-primary-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4) !important;
        }

        /* Tombol Outline (Ganti Sandi) */
        .btn-outline-modern {
            background: transparent;
            border: 2px solid var(--border-soft) !important;
            color: var(--text-muted);
        }
        .btn-outline-modern:hover {
            border-color: var(--primary-soft) !important;
            color: var(--primary-soft);
            background: rgba(79, 70, 229, 0.05);
            transform: translateY(-2px);
        }

        /* Dropdown Select Custom Elegan */
        .select-modern {
            appearance: none; /* Hilangin panah bawaan jelek */
            background-color: var(--bg-card);
            border: 2px solid var(--border-soft);
            color: var(--text-muted);
            padding: 0.5rem 2.5rem 0.5rem 1.2rem;
            border-radius: 50rem;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            /* Panah custom SVG */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            transition: all 0.3s ease;
        }
        .select-modern:focus, .select-modern:hover {
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        /* TAB NAVIGASI ELEGAN */
        .nav-pills-modern { background-color: #f1f5f9; padding: 0.35rem; border-radius: 50rem; display: inline-flex; width: 100%; justify-content: center;}
        .nav-pills-modern .nav-item { flex: 1; text-align: center; }
        .nav-pills-modern .nav-link { 
            color: var(--text-muted); 
            font-weight: 600; 
            border-radius: 50rem; 
            transition: all 0.3s ease; 
            padding: 0.6rem 1rem;
        }
        .nav-pills-modern .nav-link.active { 
            background: var(--primary-gradient) !important; 
            color: white !important; 
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3); 
        }

        /* GELEMBUNG CHAT (BUBBLE) */
        .chat-bubble {
            max-width: 80%;
            padding: 12px 18px;
            font-size: 0.95rem;
            line-height: 1.5;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 4px;
        }
        .chat-murid { background-color: var(--chat-bg-murid); border: 1px solid var(--chat-border); color: #334155; border-radius: 18px 18px 18px 4px; }
        .chat-guru { background: var(--primary-gradient); color: white; border-radius: 18px 18px 4px 18px; border: none; }
        .chat-secondary { background-color: #64748b; color: white; border-radius: 18px 18px 4px 18px; }

        /* ========================================================
           DARK MODE OVERRIDE
           ======================================================== */
        body.dark-mode {
            --bg-card: #1e293b;
            --border-soft: #334155;
            --text-muted: #94a3b8;
            --chat-bg-murid: #0f172a;
            --chat-border: #334155;
        }
        body.dark-mode .clean-card { box-shadow: 0 10px 20px rgba(0,0,0,0.3) !important; }
        body.dark-mode .text-dark, body.dark-mode h5 { color: #f8f9fa !important; }
        body.dark-mode .table { color: #e2e8f0 !important; }
        body.dark-mode .table td { border-top: 1px solid var(--border-soft) !important; }
        body.dark-mode .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.02) !important; }
        body.dark-mode .form-control { background-color: #0f172a !important; border-color: #334155 !important; color: #fff !important; }
        body.dark-mode .nav-pills-modern { background-color: #0f172a !important; border: 1px solid #334155;}
        body.dark-mode .chat-murid { color: #e2e8f0; }
        body.dark-mode .collapse td.bg-light, body.dark-mode .bg-light { background-color: #0f172a !important; }
        
        /* Tombol Khusus Dark Mode */
        body.dark-mode .btn-outline-modern { border-color: #334155 !important; color: #cbd5e1; }
        body.dark-mode .btn-outline-modern:hover { border-color: #60a5fa !important; color: #60a5fa; background: rgba(96, 165, 250, 0.1); }
        body.dark-mode .select-modern {
            background-color: #0f172a; border-color: #334155; color: #f8f9fa;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2394a3b8' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        }
        body.dark-mode .select-modern:focus, body.dark-mode .select-modern:hover { border-color: #60a5fa; box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.15); }
    </style>

    {{-- ================= VIEW GURU ================= --}}
    @if (auth()->user()->role == 'guru')
        <div class="card clean-card rounded-2xl overflow-hidden mb-5">
            <div class="card-header clean-header p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0" style="color: var(--primary-soft) !important;">
                        <i class="bi bi-chat-dots-fill me-2"></i> Manajemen Komunikasi
                    </h5>
                    
                    {{-- DROPDOWN FILTER & TOMBOL GANTI SANDI MODERN --}}
                    <div class="d-flex gap-3">
                        <select wire:model.live="bulanAktif" class="select-modern shadow-sm">
                            <option value="">Semua Waktu</option>
                            @foreach ($availableMonths as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        
                        <a href="{{ route('profile.edit') }}" class="btn-modern btn-outline-modern shadow-sm text-decoration-none">
                            <i class="bi bi-shield-lock-fill me-2"></i> Ganti Sandi
                        </a>
                    </div>
                </div>

                {{-- NAVIGASI TAB MODERN --}}
                <ul class="nav nav-pills-modern mb-1">
                    <li class="nav-item">
                        <button type="button" wire:click="$set('activeTab', 'perlu-balas')" class="nav-link w-100 {{ $activeTab == 'perlu-balas' ? 'active' : '' }}">
                            <i class="bi bi-envelope-exclamation me-2"></i> Perlu Dibalas 
                            <span class="badge bg-danger ms-2 rounded-pill">{{ $perlu_balas->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" wire:click="$set('activeTab', 'sudah-balas')" class="nav-link w-100 {{ $activeTab == 'sudah-balas' ? 'active' : '' }}">
                            <i class="bi bi-envelope-check me-2"></i> Riwayat Terbalas 
                            <span class="badge bg-secondary ms-2 rounded-pill">{{ $sudah_balas->count() }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                {{-- TAB 1: PERLU DIBALAS --}}
                <div class="tab-pane fade {{ $activeTab == 'perlu-balas' ? 'show active' : '' }}" id="perlu-balas">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($perlu_balas as $studentId => $chats)
                                    @php $last = $chats->first(); @endphp
                                    <tr data-bs-toggle="collapse" data-bs-target="#reply-{{ $studentId }}" style="cursor: pointer; border-left: 4px solid #ef4444;">
                                        <td class="ps-4 py-3 fw-bold text-dark">{{ $last->sender->name }}</td>
                                        <td class="py-3">
                                            <div class="fw-bold small text-dark">{{ $last->subject }}</div>
                                            <small style="color: var(--text-muted);">{{ Str::limit($last->body, 60) }}</small>
                                        </td>
                                        <td class="text-end pe-4 py-3 small fw-bold text-danger">{{ $last->created_at->translatedFormat('d M, H:i') }}</td>
                                    </tr>
                                    <tr class="collapse" id="reply-{{ $studentId }}" wire:ignore.self>
                                        <td colspan="3" class="bg-light p-4">
                                            <div class="mx-auto" style="max-width: 800px;">
                                                <div class="mb-4 overflow-auto pe-2" style="max-height: 350px;">
                                                    @foreach ($chats->reverse() as $chat)
                                                        <div class="mb-3 d-flex flex-column {{ $chat->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                                            <div class="chat-bubble {{ $chat->sender_id == auth()->id() ? 'chat-guru' : 'chat-murid' }}">
                                                                {{ $chat->body }}
                                                            </div>
                                                            <small style="color: var(--text-muted); font-size: 0.7rem;" class="mt-1 px-1">{{ $chat->created_at->translatedFormat('d M, H:i') }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <form action="{{ route('chat.send') }}" method="POST" class="d-flex gap-2">
                                                    @csrf
                                                    <input type="hidden" name="receiver_id" value="{{ $studentId }}">
                                                    <input type="hidden" name="subject" value="Re: {{ $last->subject }}">
                                                    <input type="text" name="body" class="form-control rounded-pill px-4 py-2" placeholder="Ketik pesan balasan..." required>
                                                    <button class="btn-modern btn-primary-glow px-4">
                                                        <i class="bi bi-send-fill me-2"></i> Kirim
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <i class="bi bi-inboxes text-muted opacity-25" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                                            <span style="color: var(--text-muted);">Hore! Semua pesan sudah dijawab.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 2: SUDAH DIBALAS --}}
                <div class="tab-pane fade {{ $activeTab == 'sudah-balas' ? 'show active' : '' }}" id="sudah-balas">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @forelse($sudah_balas as $studentId => $chats)
                                    @php
                                        $last = $chats->first();
                                        $student = $last->sender_id == auth()->id() ? $last->receiver : $last->sender;
                                    @endphp
                                    <tr data-bs-toggle="collapse" data-bs-target="#done-{{ $studentId }}" style="cursor: pointer; border-left: 4px solid #64748b;">
                                        <td class="ps-4 py-3 fw-bold text-dark">{{ $student->name }}</td>
                                        <td class="py-3">
                                            <div class="small fw-bold text-dark opacity-75">Terakhir dikirim:</div>
                                            <small style="color: var(--text-muted);">{{ Str::limit($last->body, 60) }}</small>
                                        </td>
                                        <td class="text-end pe-4 py-3 small" style="color: var(--text-muted);">Selesai {{ $last->created_at->translatedFormat('d M, H:i') }}</td>
                                    </tr>
                                    <tr class="collapse" id="done-{{ $studentId }}" wire:ignore.self>
                                        <td colspan="3" class="bg-light p-4">
                                            <div class="mx-auto" style="max-width: 800px;">
                                                <div class="mb-4 overflow-auto pe-2" style="max-height: 350px;">
                                                    @foreach ($chats->reverse() as $chat)
                                                        <div class="mb-3 d-flex flex-column {{ $chat->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                                            <div class="chat-bubble {{ $chat->sender_id == auth()->id() ? 'chat-secondary' : 'chat-murid' }}">
                                                                {{ $chat->body }}
                                                            </div>
                                                            <small style="color: var(--text-muted); font-size: 0.7rem;" class="mt-1 px-1">{{ $chat->created_at->translatedFormat('d M, H:i') }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <form action="{{ route('chat.send') }}" method="POST" class="d-flex gap-2">
                                                    @csrf
                                                    <input type="hidden" name="receiver_id" value="{{ $studentId }}">
                                                    <input type="hidden" name="subject" value="Re: {{ $last->subject }}">
                                                    <input type="text" name="body" class="form-control rounded-pill px-4 py-2" placeholder="Ketik pesan tambahan..." required>
                                                    <button class="btn-modern btn-outline-modern px-4" style="border: 2px solid #64748b !important;">
                                                        <i class="bi bi-send-plus-fill me-2"></i> Tambah
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <i class="bi bi-clock-history text-muted opacity-25" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                                            <span style="color: var(--text-muted);">Belum ada riwayat surat.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    {{-- ================= VIEW MURID ================= --}}
    @else
        <div class="row g-4 pb-5">
            <div class="col-md-5" wire:ignore>
                <div class="card clean-card rounded-2xl p-4 h-100">
                    
                    {{-- HEADER KIRI MURID + TOMBOL GANTI SANDI MODERN --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Kirim Surat Baru</h5>
                        <a href="{{ route('profile.edit') }}" class="btn-modern btn-outline-modern px-3 text-decoration-none">
                            <i class="bi bi-shield-lock-fill me-2"></i> Ganti Sandi
                        </a>
                    </div>
                    
                    @if(auth()->user()->guru_id)
                        <div class="alert bg-primary bg-opacity-10 rounded-2xl border-0 shadow-none mb-4 p-3" style="color: var(--primary-soft);">
                            <i class="bi bi-info-circle-fill me-2"></i> Guru Wali: <b class="ms-1">{{ auth()->user()->guruWali->name }}</b>
                        </div>
                        
                        <form action="{{ route('chat.send') }}" method="POST">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ auth()->user()->guru_id }}">
                            
                            <div class="mb-3">
                                <label class="small fw-bold mb-1" style="color: var(--text-muted);">Perihal</label>
                                <input type="text" name="subject" class="form-control rounded-pill px-4 py-2 bg-light border-0 shadow-sm" placeholder="Contoh: Izin Sakit" required>
                            </div>
                            <div class="mb-4">
                                <label class="small fw-bold mb-1" style="color: var(--text-muted);">Isi Surat</label>
                                <textarea name="body" class="form-control rounded-2xl p-4 bg-light border-0 shadow-sm" rows="6" placeholder="Tulis pesan lengkapmu di sini..." required style="resize: none;"></textarea>
                            </div>
                            <button class="btn-modern btn-primary-glow w-100 py-3">
                                <i class="bi bi-send-fill me-2"></i> KIRIM SURAT
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning rounded-2xl border-0 text-center py-5">
                            <i class="bi bi-exclamation-triangle-fill text-warning mb-3 d-block" style="font-size: 3rem;"></i>
                            <h5 class="fw-bold text-dark">Belum Punya Guru Wali</h5>
                            <p class="mb-0 small text-dark opacity-75">Silakan lapor ke Admin sekolah agar akun kamu segera dihubungkan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-7">
                <div class="card clean-card rounded-2xl p-4 h-100">
                    <h5 class="fw-bold mb-4 text-dark border-bottom pb-3" style="border-color: var(--border-soft) !important;">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Komunikasi
                    </h5>
                    
                    <div class="overflow-auto pe-2" style="max-height: 550px;">
                        @forelse ($myMessages as $msg)
                            <div class="mb-4 d-flex flex-column {{ $msg->sender_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}">
                                <div class="chat-bubble {{ $msg->sender_id == auth()->id() ? 'chat-guru' : 'chat-murid' }}">
                                    <div class="fw-bold mb-1" style="font-size: 0.85rem; opacity: 0.9;">{{ $msg->subject }}</div>
                                    {{ $msg->body }}
                                </div>
                                <small style="color: var(--text-muted); font-size: 0.7rem;" class="mt-1 px-1">{{ $msg->created_at->translatedFormat('d M, H:i') }}</small>
                            </div>
                        @empty
                            <div class="text-center py-5 mt-5">
                                <i class="bi bi-chat-square-text text-muted opacity-25" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                                <span style="color: var(--text-muted);">Belum ada riwayat surat. Mulai sapa Guru Walimu!</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>