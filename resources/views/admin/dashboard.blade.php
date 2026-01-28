@extends('adminlte::page')

@section('adminlte_css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('title', 'Ringkasan Sistem')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-bold m-0" style="font-size: 1.8rem; color: #1e293b;">Ringkasan Sistem</h1>
        <div class="text-muted small text-bold d-none d-md-block">{{ now()->translatedFormat('l, d F Y') }}</div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-4 fw-bold">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- 1. KARTU STATISTIK (DIBUAT BISA DIKLIK) --}}
    <div class="row">
        {{-- Kartu Guru --}}
        <div class="col-lg-4 col-md-6">
            <a href="?view=guru" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-xl mb-4 overflow-hidden bg-primary gradient-card {{ request('view') == 'guru' || (!request('view') && !request('view_guru')) ? 'active-card' : '' }}">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="opacity-75 mb-1 small text-bold">TOTAL GURU</h5>
                                <h2 class="text-bold mb-0" style="font-size: 2.2rem;">{{ $stats['total_guru'] }}</h2>
                            </div>
                            <i class="fas fa-user-tie fa-3x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{-- Kartu Murid --}}
        <div class="col-lg-4 col-md-6">
            <a href="?view=murid" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-xl mb-4 overflow-hidden bg-success gradient-card {{ request('view') == 'murid' ? 'active-card' : '' }}">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="opacity-75 mb-1 small text-bold">TOTAL MURID</h5>
                                <h2 class="text-bold mb-0" style="font-size: 2.2rem;">{{ $stats['total_murid'] }}</h2>
                            </div>
                            <i class="fas fa-user-graduate fa-3x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{-- Kartu Surat --}}
        <div class="col-lg-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-xl mb-4 overflow-hidden bg-navy gradient-card" style="background-color: #0f172a !important;">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="opacity-75 mb-1 small text-bold">TOTAL SURAT</h5>
                            <h2 class="text-bold mb-0" style="font-size: 2.2rem;">{{ $stats['total_surat'] }}</h2>
                        </div>
                        <i class="fas fa-envelope-open-text fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {{-- 2. TAMPILAN TABEL DINAMIS --}}
            @if(request('view') == 'murid')
                {{-- TABEL DAFTAR MURID --}}
                <div class="card border-0 shadow-sm rounded-xl animate__animated animate__fadeIn">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-bold text-dark"><i class="fas fa-user-graduate mr-2 text-success"></i>Daftar Semua Murid</h3>
                        <a href="{{ route('dashboard') }}" class="btn btn-xs btn-light border rounded-pill px-3">Tutup</a>
                    </div>
                    <div class="card-body px-0 py-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th class="px-4 py-3 border-0">NAMA MURID</th>
                                    <th class="border-0">EMAIL</th>
                                    <th class="border-0 text-center">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($murids as $murid)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success-soft rounded-circle p-2 mr-3 text-success text-bold" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                {{ substr($murid->name, 0, 1) }}
                                            </div>
                                            <span class="text-bold text-dark">{{ $murid->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $murid->email }}</td>
                                    <td class="text-center"><span class="badge badge-pill badge-success px-3">Aktif</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-5 text-muted">Belum ada data murid.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                {{-- TABEL DAFTAR GURU (DEFAULT) --}}
                <div class="card border-0 shadow-sm rounded-xl animate__animated animate__fadeIn">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-bold text-dark"><i class="fas fa-user-tie mr-2 text-primary"></i>Daftar Guru Aktif</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.guru') }}" class="btn btn-xs btn-primary rounded-pill px-3">Kelola Semua</a>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th class="px-4 py-3 border-0">INFO GURU</th>
                                    <th class="border-0">EMAIL</th>
                                    <th class="border-0 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gurus->take(5) as $guru)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-soft rounded-circle p-2 mr-3 text-primary text-bold" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                {{ substr($guru->name, 0, 1) }}
                                            </div>
                                            <span class="text-bold text-dark">{{ $guru->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $guru->email }}</td>
                                    <td class="text-center">
                                        <a href="?view_guru={{ $guru->id }}" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm border">
                                            <i class="fas fa-search text-primary mr-1"></i> Intip Surat
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- 3. LOG SURAT (Muncul jika tombol Intip diklik) --}}
    @if($selectedGuru)
        <div class="row mt-4 animate__animated animate__fadeInUp">
            <div class="col-12">
                <div class="card shadow-lg rounded-xl overflow-hidden border-top border-primary" style="border-width: 0; border-top-width: 4px;">
                    <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center border-0">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark text-bold">Log Komunikasi: {{ $selectedGuru->name }}</h5>
                            <small class="text-muted">Riwayat pesan untuk guru ini</small>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light border rounded-pill px-4">Tutup Log</a>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light text-muted small uppercase">
                                <tr>
                                    <th class="ps-4 py-3">WAKTU (WIB)</th>
                                    <th>PENGIRIM</th>
                                    <th>PENERIMA</th>
                                    <th>SUBJEK & ISI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allMessages as $msg)
                                    <tr class="border-bottom border-light">
                                        <td class="ps-4 py-3 small text-muted">{{ $msg->created_at->translatedFormat('d M, H:i') }}</td>
                                        <td><span class="badge badge-pill {{ $msg->sender->role == 'guru' ? 'badge-primary' : 'badge-success' }} px-3">{{ $msg->sender->name }}</span></td>
                                        <td class="small">{{ $msg->receiver->name }}</td>
                                        <td class="text-dark">
                                            <div class="text-bold small">{{ $msg->subject }}</div>
                                            <div class="small opacity-75">{{ Str::limit($msg->body, 80) }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@stop

@section('css')
<style>
    /* UI Clean 2026 Refinement */
    :root { --primary: #4e73df; --success: #1cc88a; --navy: #0f172a; }
    .rounded-xl { border-radius: 1.25rem !important; }
    .shadow-sm { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.04) !important; }
    .bg-primary-soft { background: rgba(78, 115, 223, 0.1); }
    .bg-success-soft { background: rgba(28, 200, 138, 0.1); }
    .gradient-card { transition: all 0.3s ease; border: none !important; cursor: pointer; }
    .gradient-card:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important; opacity: 0.9; }
    
    /* Active Card Indicator */
    .active-card { border-bottom: 5px solid rgba(255, 255, 255, 0.5) !important; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important; }

    /* Dark Mode Fixes */
    .dark-mode .card { background-color: #1e293b !important; color: #fff !important; }
    .dark-mode .bg-light { background-color: #0f172a !important; }
    .dark-mode .text-dark { color: #f1f5f9 !important; }
    .dark-mode .bg-white { background-color: #1e293b !important; }
</style>
@stop

@section('js')
<script>
    (function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
            const nav = document.querySelector('.main-header');
            if(nav) nav.classList.replace('navbar-light', 'navbar-dark');
        }
    })();
</script>
@stop