<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wali - Chat System</title>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: 0.3s;
        }

        [data-bs-theme="dark"] body {
            background-color: #0f172a !important;
            color: #f1f5f9;
        }

        [data-bs-theme="dark"] .card {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .navbar {
            background: #1e293b !important;
            border-bottom: 1px solid #334155;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }

        .btn-primary {
            background: #4e73df;
            border: none;
            border-radius: 12px;
            padding: 8px 20px;
            transition: 0.3s;
        }

        #theme-toggle {
            cursor: pointer;
            transition: 0.3s;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg py-3 mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">PROJECT WALI</a>
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-muted me-3 shadow-none" id="theme-toggle">
                    <i class="bi bi-moon-stars-fill fs-5" id="theme-icon"></i>
                </button>
                <span class="me-3 small text-muted">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container">{{ $slot }}</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('theme-toggle');
            const icon = document.getElementById('theme-icon');
            const html = document.documentElement;

            function updateTheme(theme) {
                html.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);
                if (theme === 'dark') {
                    icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                    icon.classList.add('text-warning');
                } else {
                    icon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
                    icon.classList.remove('text-warning');
                }
            }
            updateTheme(localStorage.getItem('theme') || 'light');
            toggleBtn.addEventListener('click', () => {
                const newTheme = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                updateTheme(newTheme);
            });
        });
    </script>
</body>

</html>
