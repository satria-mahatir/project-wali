@extends('adminlte::page')

@section('adminlte_css')
    <style>
        /* ========================================================
           UI 2026 CLEAN DESIGN SYSTEM 
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
            white-space: nowrap; /* Mencegah teks turun ke bawah */
        }
        .btn-modern:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 15px rgba(0,0,0,0.1); 
        }
        .action-flex { 
            display: flex; 
            gap: 0.5rem; 
            justify-content: center; 
            align-items: center; 
        }

        /* ========================================================
           DARK MODE OVERRIDE (Mulus & Gak Nabrak)
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
        
        /* Gradient Kotak Atas */
        .gradient-card { transition: 0.3s; border: none !important; cursor: pointer; }
        .active-card { border-bottom: 5px solid white !important; transform: scale(1.02); }
    </style>
    @livewireStyles
@stop

@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="h3 font-weight-bold text-dark mb-0">Panel Kendali Admin</h1>
        <button class="btn btn-primary btn-modern rounded-pill shadow" data-toggle="modal" data-target="#modalMurid">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Data
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success clean-card rounded-2xl mb-4 fw-bold border-left-success" style="border-left: 4px solid #10b981 !important;">
            <i class="fas fa-check-circle mr-2 text-success"></i> {{ session('success') }}
        </div>
    @endif

    {{-- 3 KOTAK STATISTIK --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-6">
            <a href="?view=guru" class="text-decoration-none">
                <div class="card bg-primary gradient-card rounded-2xl mb-4 shadow {{ request('view') == 'guru' ? 'active-card' : '' }}">
                    <div class="card-body p-4 text-white d-flex justify-content-between align-items-center">
                        <div><p class="small mb-1 font-weight-bold opacity-75">TOTAL GURU</p><h2 class="font-weight-bold mb-0">{{ $stats['total_guru'] }}</h2></div>
                        <i class="fas fa-user-tie fa-3x opacity-25"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-6">
            <a href="?view=murid" class="text-decoration-none">
                <div class="card bg-success gradient-card rounded-2xl mb-4 shadow {{ request('view') == 'murid' ? 'active-card' : '' }}">
                    <div class="card-body p-4 text-white d-flex justify-content-between align-items-center">
                        <div><p class="small mb-1 font-weight-bold opacity-75">TOTAL MURID</p><h2 class="font-weight-bold mb-0">{{ $stats['total_murid'] }}</h2></div>
                        <i class="fas fa-user-graduate fa-3x opacity-25"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-12">
            <a href="?view=surat" class="text-decoration-none">
                <div class="card bg-dark gradient-card rounded-2xl mb-4 shadow {{ request('view') == 'surat' ? 'active-card' : '' }}">
                    <div class="card-body p-4 text-white d-flex justify-content-between align-items-center">
                        <div><p class="small mb-1 font-weight-bold opacity-75">TOTAL SURAT</p><h2 class="font-weight-bold mb-0">{{ $stats['total_surat'] }}</h2></div>
                        <i class="fas fa-envelope-open-text fa-3x opacity-25"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- TABEL UTAMA (GURU / MURID / SURAT) --}}
    @if(request('view'))
    <div class="card clean-card rounded-2xl mb-5">
        <div class="card-header clean-header d-flex justify-content-between align-items-center">
            <h4 class="font-weight-bold mb-0 text-dark">
                <i class="fas fa-table mr-2 text-primary"></i> Daftar {{ ucfirst(request('view')) }}
            </h4>
            <a href="{{ route('dashboard') }}" class="btn btn-danger btn-sm rounded-pill btn-modern">
                <i class="fas fa-times mr-1"></i> Tutup
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="px-4">Nama Lengkap</th>
                            <th>{{ request('view') == 'surat' ? 'Total Pesan' : (request('view') == 'murid' ? 'Guru Wali / NISN' : 'Email') }}</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($display_data as $item)
                        <tr>
                            <td class="px-4 font-weight-bold text-dark">{{ $item->name }}</td>
                            <td>
                                @if(request('view') == 'surat')
                                    <span class="badge bg-primary rounded-pill px-3 py-2">{{ $item->sent_messages_count + $item->received_messages_count }} Pesan</span>
                                @elseif(request('view') == 'murid')
                                    <span class="badge bg-info rounded-pill px-3 py-1 mb-1"><i class="fas fa-user-tie mr-1"></i> Wali: {{ $item->guruWali->name ?? 'Belum Ada' }}</span>
                                    <br><small class="text-muted"><i class="fas fa-id-card mr-1"></i> {{ $item->username }}</small>
                                @else
                                    <span class="text-muted"><i class="fas fa-envelope mr-1"></i> {{ $item->email }}</span>
                                @endif
                            </td>
                            <td>
                                @if(request('view') == 'guru')
                                    <div class="action-flex">
                                        <a href="?view=guru&lihat_murid={{ $item->id }}" class="btn btn-sm btn-info rounded-pill btn-modern text-white">
                                            <i class="fas fa-users mr-1"></i> Lihat Murid
                                        </a>
                                        <form action="{{ route('admin.destroyGuru', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger rounded-pill btn-modern" onclick="return confirm('Hapus guru ini? Murid asuhannya akan kehilangan wali.')">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                @elseif(request('view') == 'murid')
                                    <div class="action-flex">
                                        <form action="{{ route('admin.destroyMurid', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger rounded-pill btn-modern" onclick="return confirm('Hapus data murid ini?')">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 opacity-25 d-block"></i>
                                Belum ada data.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- TABEL MURID ASUHAN (CLEAN DESIGN) --}}
    @if($selectedGuru && request()->filled('lihat_murid'))
        <div class="card clean-card rounded-2xl mb-5" style="border-left: 4px solid #0dcaf0 !important;">
            <div class="card-header clean-header d-flex justify-content-between align-items-center">
                <h4 class="font-weight-bold mb-0 text-dark">
                    <i class="fas fa-user-graduate mr-2 text-info"></i> Murid Asuhan: <span class="text-info">{{ $selectedGuru->name }}</span>
                </h4>
                <a href="?view=guru" class="btn btn-danger btn-sm rounded-pill btn-modern">
                    <i class="fas fa-times mr-1"></i> Tutup
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4" width="80">No</th>
                                <th>Nama Murid</th>
                                <th>NISN</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($muridAsuhan as $index => $murid)
                                <tr>
                                    <td class="px-4 font-weight-bold text-muted">{{ $index + 1 }}</td>
                                    <td class="font-weight-bold text-dark">{{ $murid->name }}</td>
                                    <td><span class="badge bg-secondary rounded-pill px-3 py-1">{{ $murid->username }}</span></td>
                                    <td class="text-muted"><i class="fas fa-envelope mr-2 opacity-50"></i>{{ $murid->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 opacity-25 d-block"></i>
                                        Belum ada murid yang ditugaskan ke guru ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- MODAL TAMBAH MURID & IMPORT --}}
<div class="modal fade" id="modalMurid" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content clean-card rounded-2xl border-0">
            <div class="modal-header border-bottom py-4 px-4">
                <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-database mr-2 text-primary"></i> Manajemen Data Murid</h5>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                
                {{-- 1. INPUT MANUAL --}}
                <form action="{{ route('admin.storeMurid') }}" method="POST">
                    @csrf
                    <p class="font-weight-bold mb-3 text-primary"><i class="fas fa-keyboard mr-2"></i>1. Input Manual</p>
                    <div class="form-group mb-3">
                        <select name="guru_id" class="form-control rounded-pill px-3" required>
                            <option value="">-- Pilih Guru Wali --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" name="name" class="form-control rounded-pill px-3" placeholder="Nama Lengkap Murid" required>
                    </div>
                    <div class="form-group mb-4">
                        <input type="number" name="nisn" class="form-control rounded-pill px-3" placeholder="NISN Murid" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block rounded-pill btn-modern py-2">
                        <i class="fas fa-save mr-2"></i> Simpan Data
                    </button>
                </form>

                <hr class="my-4 border-light">

                {{-- 2. IMPORT EXCEL --}}
                <form action="{{ route('admin.importMurid') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p class="font-weight-bold mb-3 text-success"><i class="fas fa-file-excel mr-2"></i>2. Import Masal (Excel)</p>
                    <div class="input-group mb-3 rounded-pill overflow-hidden border">
                        <input type="file" name="file_excel" class="form-control border-0 p-1 pl-3 bg-transparent" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success btn-modern px-4">
                                <i class="fas fa-upload mr-1"></i> Import
                            </button>
                        </div>
                    </div>
                    <div class="small p-3 bg-light rounded-lg">
                        <p class="mb-1 fw-bold text-dark"><i class="fas fa-magic mr-1 text-primary"></i> Fitur Otomatis!</p>
                        <p class="mb-2 text-muted">Sistem akan membuatkan akun guru jika nama/email guru di Excel belum terdaftar.</p>
                        <code class="text-primary d-block mb-2 bg-white px-2 py-1 rounded border">nama_murid | nisn | nama_guru | email_guru</code>
                        <p class="mb-0 text-muted opacity-75"><i class="fas fa-info-circle mr-1"></i> Sandi awal guru: <b>guru1234</b></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    @livewireScripts
@stop