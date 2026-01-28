@extends('adminlte::page')

@section('adminlte_css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('title', 'Manajemen Guru Wali')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-bold m-0" style="font-size: 1.8rem; color: #1e293b;">Data Guru Wali</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill shadow-sm px-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-4 fw-bold">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        {{-- Form Registrasi --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-xl">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title text-bold">Registrasi Guru Baru</h3>
                </div>
                <div class="card-body px-4 pb-4">
                    <form action="{{ route('admin.storeGuru') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="text-muted small">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control rounded-lg border-light bg-light py-4" placeholder="Masukkan nama..." required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-muted small">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-lg border-light bg-light py-4" placeholder="email@sekolah.id" required>
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-muted small">Password Akun</label>
                            <input type="password" name="password" class="form-control rounded-lg border-light bg-light py-4" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg text-bold rounded-lg shadow-sm">Daftarkan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table Guru --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-xl h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="card-title text-bold">Arsip Guru Aktif</h3>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3 text-muted small">NAMA GURU</th>
                                    <th class="border-0 px-4 py-3 text-muted small text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gurus as $guru)
                                <tr class="border-bottom border-light">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-soft rounded-circle p-2 mr-3 text-primary text-bold" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                {{ substr($guru->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-bold text-dark">{{ $guru->name }}</div>
                                                <div class="small text-muted">{{ $guru->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('dashboard') }}?view_guru={{ $guru->id }}" class="btn btn-light btn-sm rounded-pill mr-1 px-3">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                            <form action="{{ route('admin.destroyGuru', $guru->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm rounded-pill px-3" onclick="return confirm('Hapus?')">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root { --primary: #4e73df; --navy: #0f172a; }
    .rounded-xl { border-radius: 1.25rem !important; }
    .rounded-lg { border-radius: 0.75rem !important; }
    .bg-primary-soft { background: rgba(78, 115, 223, 0.1); }
    .dark-mode .card { background-color: #1e293b !important; color: #fff !important; }
    .dark-mode table { color: #f1f5f9 !important; }
</style>
@stop