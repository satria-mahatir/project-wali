<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wali | Hubungkan Guru & Murid</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .hero-area {
            background: radial-gradient(circle at top right, rgba(78, 115, 223, 0.1), transparent),
                radial-gradient(circle at bottom left, rgba(28, 200, 138, 0.05), transparent);
            padding: 98px 0 60px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8) !important;
            padding: 12px 0;
            transition: background 0.3s ease;
        }

        [data-bs-theme="dark"] .navbar {
            background: rgba(33, 37, 41, 0.8) !important;
        }

        .nav-link {
            font-weight: 600;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            background: linear-gradient(135deg, #1a202c 0%, #4e73df 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        [data-bs-theme="dark"] .hero-title {
            background: linear-gradient(135deg, #ffffff 0%, #4e73df 100%);
            -webkit-background-clip: text;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white !important;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(78, 115, 223, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(78, 115, 223, 0.3);
        }

        section {
            scroll-margin-top: 80px;
        }

        #fitur {
            padding: 80px 0;
        }

        .feature-card {
            border: none;
            border-radius: 24px;
            padding: 30px;
            transition: all 0.3s ease;
            background: var(--bs-body-bg);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .floating-blob {
            position: absolute;
            z-index: -1;
            filter: blur(80px);
            border-radius: 50%;
            background: var(--primary-color);
            opacity: 0.1;
        }

        #themeToggle {
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--bs-nav-link-color);
        }

        [data-bs-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] #fitur h2, 
        [data-bs-theme="dark"] .feature-card h5 {
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .btn-outline-dark {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
        }

        [data-bs-theme="dark"] .btn-outline-dark:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #ffffff !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-extrabold text-primary d-flex align-items-center" href="#">
                <i class="bi bi-chat-heart-fill me-2"></i> WALI.
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link px-3" href="#fitur">Fitur</a></li>

                    <li class="nav-item px-2">
                        <div id="themeToggle" title="Ganti Mode">
                            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                        </div>
                    </li>

                    @auth
                        <li class="nav-item">
                            <a class="btn btn-gradient ms-md-3" href="{{ url('/dashboard') }}">Masuk Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item">
                            <a class="btn btn-gradient ms-md-3" href="{{ route('register') }}">Daftar Murid</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-area position-relative overflow-hidden">
        <div class="floating-blob" style="width: 100px; height: 100px; top: -100px; right: -100px;"></div>
        <div class="floating-blob"
            style="width: 400px; height: 400px; bottom: -50px; left: -100px; background: #1cc88a;"></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-bold">
                        Solusi Chat Sekolah Modern
                    </span>
                    <h1 class="hero-title">Chat Guru Tanpa Ribet, Pantau Belajar Lebih Menyenangkan.</h1>
                    <p class="lead text-muted mb-4" style="font-size: 1.1rem;">
                        Aplikasi Wali menghubungkan murid dan guru wali dalam satu platform aman, transparan, dan mudah
                        digunakan.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-gradient btn-lg text-nowrap">Coba Sekarang —
                            Gratis</a>
                        <a href="#fitur" class="btn btn-outline-dark border-2 fw-bold btn-lg d-flex align-items-center"
                            id="btnFitur">
                            <i class="bi bi-play-circle me-2"></i>Fitur
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="https://illustrations.popsy.co/white/studying.svg" alt="Illustration" class="img-fluid"
                        style="max-height: 450px;">
                </div>
            </div>
        </div>
    </header>

    <section id="fitur">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">Kenapa Harus Menggunakan Wali?</h2>
                    <p class="text-muted">Didesain khusus untuk mempermudah komunikasi akademik.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100 text-center border shadow-sm">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h5 class="fw-bold">Privasi Terjaga</h5>
                        <p class="text-muted small">Chat aman antara guru dan murid tanpa perlu berbagi nomor telepon
                            pribadi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100 text-center border shadow-sm">
                        <div class="icon-box bg-success bg-opacity-10 text-success mx-auto">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h5 class="fw-bold">Monitoring Admin</h5>
                        <p class="text-muted small">Semua percakapan dipantau oleh admin sekolah demi menjaga etika dan
                            keamanan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100 text-center border shadow-sm">
                        <div class="icon-box bg-info bg-opacity-10 text-info mx-auto">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h5 class="fw-bold">Akses Kapan Saja</h5>
                        <p class="text-muted small">Tersedia dalam versi Web dan segera hadir dalam versi Mobile
                            (Flutter).</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-body-tertiary border-top">
        <div class="container text-center">
            <p class="text-muted mb-0 small">© 2026 Project Guru Wali - Dibuat oleh Tama</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        function setTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);

            if (theme === 'dark') {
                themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                document.documentElement.classList.add('dark');
            } else {
                themeIcon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
                document.documentElement.classList.remove('dark');
            }
        }

        const currentTheme = localStorage.getItem('theme') || 'light';
        setTheme(currentTheme);

        themeToggle.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
        });
    </script>
</body>

</html>