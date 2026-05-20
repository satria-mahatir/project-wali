<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark-title" style="margin: 0;">
                {{ __('Pengaturan Akun') }}
            </h2>
            
            {{-- TOMBOL KEMBALI KE DASHBOARD --}}
            <a href="{{ route('dashboard') }}" style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 9999px; font-weight: bold; text-decoration: none; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: 0.3s;">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    {{-- CSS SAKTI BUAT NAKLUKIN DARK MODE & LIGHT MODE --}}
    <style>
        /* Kalau class dark-mode aktif, kita sulap jadi gelap elegan */
        html.dark .bg-white, .dark-mode .bg-white { background-color: #1e293b !important; border-color: #334155 !important; }
        html.dark .dark-title, html.dark h5, html.dark label, .dark-mode .dark-title, .dark-mode h5, .dark-mode label { color: #f8f9fa !important; }
        html.dark p.text-muted, .dark-mode p.text-muted { color: #94a3b8 !important; }
        html.dark .card, .dark-mode .card { background-color: #1e293b !important; border: 1px solid #334155 !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5) !important; }
        html.dark .form-control, .dark-mode .form-control { background-color: #334155 !important; color: #ffffff !important; border: 1px solid #475569 !important; }
        html.dark .form-control:focus, .dark-mode .form-control:focus { background-color: #475569 !important; color: #ffffff !important; border-color: #60a5fa !important; }
        html.dark .btn-dark, .dark-mode .btn-dark { background-color: #3b82f6 !important; border: none !important; }
        html.dark .btn-dark:hover, .dark-mode .btn-dark:hover { background-color: #2563eb !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="row g-4" style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
                
                {{-- KOTAK 1: UPDATE PROFIL --}}
                <div class="col-md-6" style="flex: 1; min-width: 300px;">
                    <div class="card bg-white border-0 shadow-sm rounded-4 h-100 p-4" style="border-radius: 1rem; padding: 1.5rem; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);">
                        <h5 class="fw-bold mb-1" style="font-weight: bold; font-size: 1.25rem;">Informasi Profil</h5>
                        <p class="text-muted small mb-4" style="color: #6c757d; font-size: 0.875em; margin-bottom: 1.5rem;">Perbarui nama dan alamat email akun kamu.</p>
                        
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')
                            <div class="mb-3" style="margin-bottom: 1rem;">
                                <label class="form-label fw-bold small" style="font-weight: bold; font-size: 0.875em;">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-pill px-3" style="width: 100%; padding: 0.5rem 1rem; border-radius: 50rem; border: 1px solid #ced4da;" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name') <span class="text-danger small" style="color: #dc3545; font-size: 0.875em;">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4" style="margin-bottom: 1.5rem;">
                                <label class="form-label fw-bold small" style="font-weight: bold; font-size: 0.875em;">Email / Username Login</label>
                                <input type="email" name="email" class="form-control rounded-pill px-3" style="width: 100%; padding: 0.5rem 1rem; border-radius: 50rem; border: 1px solid #ced4da;" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email') <span class="text-danger small" style="color: #dc3545; font-size: 0.875em;">{{ $message }}</span> @enderror
                            </div>
                            <div class="d-flex align-items-center" style="display: flex; align-items: center;">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" style="background-color: #0d6efd; color: white; padding: 0.5rem 1.5rem; border-radius: 50rem; border: none; font-weight: bold; cursor: pointer;">Simpan Profil</button>
                                @if (session('status') === 'profile-updated')
                                    <span class="text-success small ms-3 fw-bold" style="color: #198754; font-size: 0.875em; font-weight: bold; margin-left: 1rem;">Berhasil disimpan.</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- KOTAK 2: UPDATE PASSWORD --}}
                <div class="col-md-6" style="flex: 1; min-width: 300px;">
                    <div class="card bg-white border-0 shadow-sm rounded-4 h-100 p-4" style="border-radius: 1rem; padding: 1.5rem; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);">
                        <h5 class="fw-bold mb-1" style="font-weight: bold; font-size: 1.25rem;">Ubah Kata Sandi</h5>
                        <p class="text-muted small mb-4" style="color: #6c757d; font-size: 0.875em; margin-bottom: 1.5rem;">Pastikan akun kamu menggunakan kata sandi yang panjang dan acak.</p>
                        
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')
                            <div class="mb-3" style="margin-bottom: 1rem;">
                                <label class="form-label fw-bold small" style="font-weight: bold; font-size: 0.875em;">Sandi Saat Ini</label>
                                <input type="password" name="current_password" class="form-control rounded-pill px-3" style="width: 100%; padding: 0.5rem 1rem; border-radius: 50rem; border: 1px solid #ced4da;" required>
                                @error('current_password', 'updatePassword') <span class="text-danger small" style="color: #dc3545; font-size: 0.875em;">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3" style="margin-bottom: 1rem;">
                                <label class="form-label fw-bold small" style="font-weight: bold; font-size: 0.875em;">Sandi Baru</label>
                                <input type="password" name="password" class="form-control rounded-pill px-3" style="width: 100%; padding: 0.5rem 1rem; border-radius: 50rem; border: 1px solid #ced4da;" required>
                                @error('password', 'updatePassword') <span class="text-danger small" style="color: #dc3545; font-size: 0.875em;">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4" style="margin-bottom: 1.5rem;">
                                <label class="form-label fw-bold small" style="font-weight: bold; font-size: 0.875em;">Konfirmasi Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-pill px-3" style="width: 100%; padding: 0.5rem 1rem; border-radius: 50rem; border: 1px solid #ced4da;" required>
                            </div>
                            <div class="d-flex align-items-center" style="display: flex; align-items: center;">
                                <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" style="background-color: #212529; color: white; padding: 0.5rem 1.5rem; border-radius: 50rem; border: none; font-weight: bold; cursor: pointer;">Update Sandi</button>
                                @if (session('status') === 'password-updated')
                                    <span class="text-success small ms-3 fw-bold" style="color: #198754; font-size: 0.875em; font-weight: bold; margin-left: 1rem;">Sandi diperbarui.</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>