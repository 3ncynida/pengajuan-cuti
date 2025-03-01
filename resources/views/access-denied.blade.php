<!DOCTYPE html>
<html>
<head>
    <title>Access Denied</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .error-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }
        .error-code {
            font-size: 72px;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 24px;
            color: #343a40;
            margin-bottom: 30px;
        }
        .error-description {
            color: #6c757d;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-code">403</div>
            <h1 class="error-message">Access Denied</h1>
            <p class="error-description">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                Silakan kembali ke halaman utama atau hubungi administrator jika Anda memerlukan bantuan.
            </p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary px-4">
                        Kembali ke Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-primary px-4">
                        Kembali ke Dashboard
                    </a>
                @endif
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary px-4">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>