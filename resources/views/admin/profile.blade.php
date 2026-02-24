@extends('adminlte::page')

@section('adminlte_css')
    <style>
        /* 1. NUCLEAR INJECTION - Ganti Variabel Warna Sistem */
        :root {
            --dark: #0f172a !important;
            --light: #1e293b !important;
        }

        /* 2. PAKSA BACKGROUND UTAMA */
        body.dark-mode .content-wrapper {
            background-color: #0f172a !important;
        }

        /* 3. PAKSA SEMUA CARD JADI GELAP SLATE */
        body.dark-mode .card {
            background-color: #1e293b !important;
            color: #f8f9fa !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .card-header {
            border-bottom: 1px solid #334155 !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        /* 4. FIX FORM INPUT AGAR TIDAK SILAU */
        body.dark-mode .form-control {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .form-control:focus {
            border-color: #3b82f6 !important;
            background-color: #111827 !important;
        }

        /* 5. FIX WARNA TEKS */
        body.dark-mode label,
        body.dark-mode .profile-username,
        body.dark-mode .list-group-item b,
        body.dark-mode h3 {
            color: #ffffff !important;
        }

        body.dark-mode .text-muted {
            color: #94a3b8 !important;
        }

        /* 6. FIX LIST GROUP (STATISTIK) */
        body.dark-mode .list-group-item {
            background-color: transparent !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        /* 7. UTILITY TAMA */
        .rounded-xl {
            border-radius: 1.25rem !important;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid pt-4">
        <div class="row">
            {{-- SISI KIRI --}}
            <div class="col-md-4">
                <div class="card card-primary card-outline rounded-xl shadow-lg border-0">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle border-0 shadow-sm"
                                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4e73df&color=fff&size=128"
                                alt="Admin profile">
                        </div>
                        <h3 class="profile-username text-center mt-3 text-bold">{{ auth()->user()->name }}</h3>
                        <p class="text-muted text-center text-uppercase small">{{ auth()->user()->role }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email Akun</b> <span
                                    class="float-right small opacity-75">{{ auth()->user()->email }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Total Guru</b> <span
                                    class="float-right badge badge-primary px-2">{{ $stats['total_guru'] }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Total Murid</b> <span
                                    class="float-right badge badge-success px-2">{{ $stats['total_murid'] }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- SISI KANAN --}}
            <div class="col-md-8">
                <div class="card rounded-xl shadow-lg border-0">
                    <div class="card-header border-0 pt-4 px-4 bg-transparent">
                        <h3 class="card-title text-bold text-primary">
                            <i class="fas fa-user-cog mr-2"></i> Pengaturan Akun Administrator
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success border-0 rounded-pill px-4 small mb-4 shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-pill px-3"
                                    value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="form-group mb-4">
                                <label>Email Utama</label>
                                <input type="email" name="email" class="form-control rounded-pill px-3"
                                    value="{{ auth()->user()->email }}" required>
                            </div>

                            <hr class="my-4" style="opacity: 0.1">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="small text-bold">Password Baru</label>
                                    <input type="password" name="password" class="form-control rounded-pill px-3"
                                        placeholder="Minimal 8 karakter">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-bold">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control rounded-pill px-3" placeholder="Ulangi password">
                                </div>
                            </div>

                            <div class="mt-4 text-right">
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm text-bold">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
