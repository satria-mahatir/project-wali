<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wali - Chat System</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f4f7fa; 
            color: #2d3748;
        }
        .navbar { background: #fff !important; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); }
        .btn-primary { background: #4e73df; border: none; border-radius: 12px; padding: 10px 20px; transition: 0.3s; }
        .btn-primary:hover { background: #2e59d9; transform: translateY(-2px); }
        .btn-success { background: #1cc88a; border: none; border-radius: 12px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">PROJECT WALI</a>
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