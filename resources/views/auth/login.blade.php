<!DOCTYPE html>
<html>
<head>
    <title>Karyawan Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --text-color: #333;
            --light-bg: #f8f9fa;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 15px;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            margin: 0 auto;
        }
        
        .login-container:hover {
            transform: translateY(-5px);
        }
        
        .login-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--text-color);
            font-weight: 600;
        }
        
        .login-subtitle {
            text-align: center;
            margin-bottom: 2rem;
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
            border-color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .input-group-text {
            background-color: white;
            border-right: none;
            cursor: pointer;
        }
        
        .password-toggle {
            border-left: none;
        }
        
        .form-control.password-input {
            border-left: none;
        }
        
        .register-link {
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .register-link:hover {
            color: var(--primary-hover);
            text-decoration: underline !important;
        }
        
        .error-modal .modal-header {
            background-color: #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .card-brand {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .brand-logo {
            height: 60px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="login-container">
            <div class="card-brand">
                <!-- Replace with your company logo -->
                <div class="brand-logo">
                    <i class="fas fa-building fa-3x text-primary"></i>
                </div>
            </div>
            <h2 class="login-title">Welcome Back</h2>
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="name@company.com"
                                required
                                autofocus>
                    </div>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password"
                                class="form-control password-input @error('password') is-invalid @enderror"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                required>
                        <span class="input-group-text password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>
                
            <div class="text-center mt-4">
                <span class="text-muted">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-decoration-none register-link">Register here</a>
            </div>
        </div>
    </div>
    
    <!-- Error Modal -->
    <div class="modal fade error-modal" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="errorModalLabel">Login Gagal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="text-center mb-3">
                            <i class="fas fa-exclamation-circle text-danger fa-3x mb-3"></i>
                            <h5 class="text-danger">Authentication Error</h5>
                        </div>
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="text-danger py-1"><i class="fas fa-times-circle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
    
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        });
    </script>
    @endif
</body>
</html>