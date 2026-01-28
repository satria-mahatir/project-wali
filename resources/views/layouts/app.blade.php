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

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bs-tertiary-bg); 
            color: var(--bs-body-color);
            transition: background-color 0.3s ease;
        }

        [data-bs-theme="dark"] body { background-color: #0f172a !important; }
        
        [data-bs-theme="dark"] .bg-white,
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .modal-content {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .navbar { 
            background: #1e293b !important; 
            border-bottom: 1px solid #334155;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); 
        }

        [data-bs-theme="dark"] .form-control, 
        [data-bs-theme="dark"] .form-select {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #334155 !important;
            color: #f1f5f9 !important;
        }

        [data-bs-theme="dark"] .table {
            --bs-table-bg: #1e293b;
            --bs-table-color: #f1f5f9;
            border-color: #334155;
        }

        .btn-primary { background: #4e73df; border: none; border-radius: 12px; padding: 10px 20px; transition: 0.3s; }
        .btn-primary:hover { background: #2e59d9; transform: translateY(-2px); }
        .btn-success { background: #1cc88a; border: none; border-radius: 12px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">PROJECT WALI</a>
            <div class="d-flex align-items-center">
                <span class="me-3 small text-muted">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container">
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>