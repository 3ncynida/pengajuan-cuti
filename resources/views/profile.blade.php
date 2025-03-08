@extends('layouts.template.app')

@section('title', 'Complete Profile')

@push('css')
<style>
    :root {
        --primary-light: #e3f2fd;
        --primary-main: #2196f3;
        --primary-dark: #1e88e5;
        --secondary-main: #012970;
        --success-light: #e8f5e9;
        --success-main: #4caf50;
        --danger-light: #ffebee;
        --danger-main: #ef5350;
    }

    .main {
        margin-top: 0;
        padding: 20px 30px;
        min-height: 100vh;
    }

    .profile-section {
        padding: 60px 0;  /* Increased padding to center content better */
        border-radius: 20px;
        background: #f6f9ff;
    }

    .profile-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        border: none;
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(to right, var(--primary-light), #ffffff);
        padding: 25px 30px;
        border-bottom: 2px solid rgba(33, 150, 243, 0.1);
    }

    .profile-title {
        color: var(--secondary-main);
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    .profile-body {
        padding: 30px;
    }

    .form-label {
        color: var(--secondary-main);
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 18px;
        border-color: #e0e8f9;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-main);
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
    }

    .form-control:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }

    .text-muted {
        color: #6c757d !important;
        font-size: 13px;
        margin-top: 5px;
    }

    .btn {
        padding: 12px 24px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--primary-main);
        border: none;
        box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(33, 150, 243, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(108, 117, 125, 0.3);
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: var(--success-light);
        color: #2e7d32;
        border-left: 4px solid var(--success-main);
    }

    .alert-danger {
        background: var(--danger-light);
        color: #c62828;
        border-left: 4px solid var(--danger-main);
    }

    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: 2px solid rgba(33, 150, 243, 0.1);
    }

    .modal-body {
        padding: 25px;
    }

    .invalid-feedback {
        font-size: 13px;
        margin-top: 5px;
    }
</style>
@endpush


@section('content')
<main id="main" class="main">
    <section class="profile-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="profile-card">
                        <div class="profile-header">
                            <h2 class="profile-title">Lengkapi profilemu</h2>
                        </div>
                        
                        <div class="profile-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('karyawan.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_karyawan" class="form-label">Nama Karyawan:</label>
                    <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror"
                        name="nama_karyawan" id="nama_karyawan"
                        value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" maxlength="25">
                    @error('nama_karyawan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" value="{{ $karyawan->email }}" disabled>
                    <small class="text-muted">Email tidak bisa dirubah</small>
                </div>

                <div class="mb-3">
                    <label for="nohp" class="form-label">No. HP:</label>
                    <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp"
                        id="nohp" value="{{ old('nohp', $karyawan->nohp) }}" maxlength="20">
                    @error('nohp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jabatan_id" class="form-label">Jabatan:</label>
                    <input type="text" class="form-control" value="{{ $karyawan->jabatan->nama_jabatan ?? '' }}"
                        disabled>
                    <small class="text-muted">Jabatan tidak bisa dirubah</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>

            <div class="d-grid gap-2 mt-3">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                @else
                    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif
</div>
</div>
</div>
</div>
</div>
</section>
</main>
@endsection
