@extends('adminlte::page')

@section('adminlte_css')
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
        }

        .rounded-xl {
            border-radius: 1.25rem !important;
        }

        .gradient-card {
            transition: 0.3s;
            border: none !important;
            cursor: pointer;
        }

        .gradient-card:hover {
            transform: translateY(-5px);
            filter: brightness(1.1);
        }

        .active-card {
            border-bottom: 5px solid rgba(255, 255, 255, 0.8) !important;
        }

        /* FIX DARK MODE */
        .dark-mode .card:not(.gradient-card) {
            background-color: #1e293b !important;
            color: #fff !important;
        }

        .dark-mode .table {
            color: #fff !important;
        }

        .dark-mode .bg-light {
            background-color: #334155 !important;
            color: #fff !important;
        }

        /* Custom Chat Styling */
        .chat-list-item {
            transition: 0.2s;
            border-left: 4px solid transparent;
        }

        .chat-list-item.active {
            background-color: #e9ecef !important;
            border-left: 4px solid var(--primary);
        }

        .chat-box {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        }
    </style>
    @livewireStyles
@stop

@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center pt-3">
            <h1 class="h3 mb-0 text-gray-800 text-bold">Panel Kendali Admin</h1>
            <button id="dark-mode-toggle" class="btn btn-outline-secondary rounded-pill shadow-sm">
                <i class="fas fa-moon"></i> Ganti Mode
            </button>
        </div>

        {{-- Kartu Statistik --}}
        <div class="row mt-4">
            <div class="col-lg-4">
                <a href="?view=guru" class="text-decoration-none">
                    <div
                        class="card bg-primary gradient-card rounded-xl mb-4 {{ request('view') == 'guru' ? 'active-card' : '' }}">
                        <div class="card-body p-4 text-white d-flex justify-content-between">
                            <div>
                                <h5 class="small text-bold opacity-75">TOTAL GURU</h5>
                                <h2>{{ $stats['total_guru'] }}</h2>
                            </div>
                            <i class="fas fa-user-tie fa-3x opacity-25"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="?view=murid" class="text-decoration-none">
                    <div
                        class="card bg-success gradient-card rounded-xl mb-4 {{ request('view') == 'murid' ? 'active-card' : '' }}">
                        <div class="card-body p-4 text-white d-flex justify-content-between">
                            <div>
                                <h5 class="small text-bold opacity-75">TOTAL MURID</h5>
                                <h2>{{ $stats['total_murid'] }}</h2>
                            </div>
                            <i class="fas fa-user-graduate fa-3x opacity-25"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="?view=surat" class="text-decoration-none">
                    <div
                        class="card bg-dark gradient-card rounded-xl mb-4 {{ request('view') == 'surat' ? 'active-card' : '' }}">
                        <div class="card-body p-4 text-white d-flex justify-content-between">
                            <div>
                                <h5 class="small text-bold opacity-75">TOTAL SURAT</h5>
                                <h2>{{ $stats['total_surat'] }}</h2>
                            </div>
                            <i class="fas fa-envelope-open-text fa-3x opacity-25"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- TABEL DETAIL DINAMIS --}}
        @if (request('view'))
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-xl overflow-hidden">
                        <div
                            class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-bold text-primary">Detail Data: {{ ucfirst(request('view')) }}</h3>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light rounded-pill px-3">Tutup</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase">
                                        <tr>
                                            <th class="px-4 py-3 border-0">Nama Lengkap</th>
                                            @if (request('view') == 'surat')
                                                <th class="px-4 py-3 border-0">Total Surat Masuk</th>
                                            @else
                                                <th class="px-4 py-3 border-0">Alamat Email</th>
                                            @endif
                                            @if (request('view') == 'guru')
                                                <th class="px-4 py-3 border-0 text-center">Tindakan</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($display_data as $item)
                                            <tr>
                                                <td class="px-4 py-3 text-bold">{{ $item->name }}</td>
                                                <td class="px-4 py-3">
                                                    @if (request('view') == 'surat')
                                                        <span
                                                            class="badge badge-primary px-3 py-2 rounded-pill shadow-sm">{{ $item->total_pesan }}
                                                            Pesan</span>
                                                    @else
                                                        {{ $item->email }}
                                                    @endif
                                                </td>
                                                @if (request('view') == 'guru')
                                                    <td class="text-center">
                                                        <a href="?view=guru&view_guru={{ $item->id }}"
                                                            class="btn btn-sm btn-info rounded-pill px-3 shadow-sm">
                                                            <i class="fas fa-search-eye mr-1"></i> Intip Chat
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-5 text-muted">Data tidak ditemukan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- PANEL MONITORING CHAT (Hanya muncul jika guru dipilih) --}}
        @if ($selectedGuru)
            <div class="row mt-4 pb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-xl overflow-hidden">
                        <div
                            class="card-header bg-primary text-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h3 class="card-title text-bold mb-0">
                                <i class="fas fa-satellite-dish mr-2"></i> Monitoring Live: {{ $selectedGuru->name }}
                            </h3>
                            <a href="{{ route('dashboard') }}?view=guru" class="text-white"><i
                                    class="fas fa-times-circle fa-lg"></i></a>
                        </div>
                        <div class="card-body p-0">
                            {{-- PANGGIL LIVEWIRE --}}
                            @livewire('monitoring-chat', ['guruId' => $selectedGuru->id])
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

@section('js')
    @livewireScripts
    <script>
        const btn = document.querySelector('#dark-mode-toggle');
        const body = document.body;
        const nav = document.querySelector('.main-header');

        function updateMode(isDark) {
            if (isDark) {
                body.classList.add('dark-mode');
                if (nav) nav.classList.replace('navbar-white', 'navbar-dark');
                btn.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
            } else {
                body.classList.remove('dark-mode');
                if (nav) nav.classList.replace('navbar-dark', 'navbar-white');
                btn.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
            }
        }

        const savedMode = localStorage.getItem('theme') === 'dark';
        updateMode(savedMode);

        btn.addEventListener('click', () => {
            const isDark = body.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateMode(isDark);
        });
    </script>
@stop
