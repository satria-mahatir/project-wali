@extends('adminlte::page')

@section('title', 'Manajemen Guru')

@section('adminlte_css')
    <style>
        /* ========================================================
           UI 2026 CLEAN DESIGN SYSTEM (SINKRON DENGAN DASHBOARD)
           ======================================================== */
        :root { 
            --primary-soft: #4f46e5; 
            --bg-card: #ffffff; 
            --border-soft: #e2e8f0; 
            --text-muted: #64748b;
        }

        /* CARD SUPER CLEAN */
        .rounded-2xl { border-radius: 1.25rem !important; }
        .clean-card { 
            background-color: var(--bg-card) !important; 
            border: 1px solid var(--border-soft) !important; 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025) !important; 
            backdrop-filter: blur(10px);
        }
        .clean-header { 
            background-color: transparent !important; 
            border-bottom: 1px solid var(--border-soft) !important; 
            padding: 1.25rem 1.5rem !important; 
        }

        /* TABEL ELEGAN */
        .table th { 
            font-weight: 700; 
            letter-spacing: 0.8px; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            color: var(--text-muted);
            border-top: none !important;
            border-bottom: 2px solid var(--border-soft) !important;
        }
        .table td { 
            vertical-align: middle !important; 
            padding: 1rem 1.5rem !important; 
        }

        /* TOMBOL MASA DEPAN */
        .btn-modern { 
            font-weight: 600; 
            padding: 0.5rem 1.25rem; 
            letter-spacing: 0.3px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            border: none; 
            white-space: nowrap; 
        }
        .btn-modern:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 15px rgba(0,0,0,0.1); 
        }

        /* ========================================================
           DARK MODE OVERRIDE (Adem di Mata)
           ======================================================== */
        .dark-mode {
            --bg-card: #1e293b;
            --border-soft: #334155;
            --text-muted: #94a3b8;
        }
        .dark-mode .clean-card { box-shadow: 0 10px 20px rgba(0,0,0,0.3) !important; }
        .dark-mode .text-dark { color: #f8f9fa !important; }
        .dark-mode .table { color: #e2e8f0 !important; }
        .dark-mode .table td { border-top: 1px solid var(--border-soft) !important; }
        .dark-mode .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.02) !important; }
        .dark-mode .form-control { background-color: #0f172a !important; border-color: #334155 !important; color: #fff !important; }
        .dark-mode .form-control:focus { border-color: #60a5fa !important; box-shadow: 0 0 0 0.25rem rgba(96, 165, 250, 0.25) !important;}
        .dark-mode .modal-content { background-color: #1e293b !important; border: 1px solid #334155 !important; }
    </style>
@stop

@section('content')
<div class="container-fluid pt-4 pb-5">
    
    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="h3 font-weight-bold text-dark mb-0">Manajemen Guru</h1>
        <button class="btn btn-primary btn-modern rounded-pill shadow" data-toggle="modal" data-target="#modalGuru">
            <i class="fas fa-user-plus mr-2"></i> Tambah Guru
        </button>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if (session('success'))
        <div class="alert alert-success clean-card rounded-2xl mb-4 fw-bold border-0" style="border-left: 4px solid #10b981 !important;">
            <i class="fas fa-check-circle mr-2 text-success"></i> {{ session('success') }}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger clean-card rounded-2xl mb-4 fw-bold border-0" style="border-left: 4px solid #ef4444 !important;">
            <i class="fas fa-exclamation-circle mr-2 text-danger"></i> Ada kesalahan input! Cek kembali data yang diisi.
        </div>
    @endif

    {{-- TABEL DAFTAR GURU --}}
    <div class="card clean-card rounded-2xl mb-5 border-0">
        <div class="card-header clean-header d-flex justify-content-between align-items-center">
            <h4 class="font-weight-bold mb-0 text-dark">
                <i class="fas fa-chalkboard-teacher mr-2 text-primary"></i> Daftar Guru Terdaftar
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-4" width="80">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email Login</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $index => $guru)
                        <tr>
                            <td class="px-4 font-weight-bold text-muted">{{ $index + 1 }}</td>
                            <td class="font-weight-bold text-dark">{{ $guru->name }}</td>
                            <td>
                                <span class="text-muted"><i class="fas fa-envelope mr-2 opacity-50"></i>{{ $guru->email }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.destroyGuru', $guru->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-pill btn-modern px-3" onclick="return confirm('Yakin ingin menghapus guru ini? Semua murid asuhannya akan kehilangan guru wali.')">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash fa-3x mb-3 opacity-25 d-block"></i>
                                Belum ada data guru. Silakan tambahkan guru baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH GURU MODERN --}}
<div class="modal fade" id="modalGuru" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content clean-card rounded-2xl border-0">
            <div class="modal-header border-bottom py-4 px-4">
                <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-user-plus mr-2 text-primary"></i> Tambah Guru Baru</h5>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.storeGuru') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="letter-spacing: 0.5px;">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-pill px-4 py-2 shadow-sm" placeholder="Contoh: Budi Santoso, S.Pd" value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="letter-spacing: 0.5px;">Email Login</label>
                        <input type="email" name="email" class="form-control rounded-pill px-4 py-2 shadow-sm" placeholder="Contoh: budi@sekolah.com" value="{{ old('email') }}" required>
                        @error('email') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="letter-spacing: 0.5px;">Kata Sandi Awal</label>
                        <input type="password" name="password" class="form-control rounded-pill px-4 py-2 shadow-sm" placeholder="Minimal 8 karakter" required minlength="8">
                        @error('password') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        <small class="text-muted mt-2 d-block opacity-75"><i class="fas fa-info-circle mr-1"></i> Guru dapat mengganti sandi ini nanti.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block rounded-pill btn-modern py-2 mt-4 shadow">
                        <i class="fas fa-save mr-2"></i> Simpan Data Guru
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop