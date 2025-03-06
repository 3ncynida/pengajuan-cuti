<!-- filepath: /C:/laragon/www/pengajuan-cuti/resources/views/karyawan/cuti/create.blade.php -->
@extends('layouts.template.app')

@section('title', 'Pengajuan Cuti')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    :root {
        --primary-light: #e3f2fd;
        --primary-main: #2196f3;
        --primary-dark: #1e88e5;
        --warning-light: #fff8e1;
        --warning-main: #ffa000;
        --success-light: #e8f5e9;
        --success-main: #4caf50;
        --danger-light: #ffebee;
        --danger-main: #ef5350;
        --secondary-main: #012970;
    }

    .main {
        margin-top: 60px;
        padding: 20px 30px;
        background: #f6f9ff;
        min-height: calc(100vh - 60px);
    }

    .form-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        border: none;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .form-header {
        background: linear-gradient(to right, var(--primary-light), #ffffff);
        padding: 25px 30px;
        border-bottom: 2px solid rgba(33, 150, 243, 0.1);
    }

    .form-title {
        color: var(--secondary-main);
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    .form-body {
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

    textarea.form-control {
        min-height: 120px;
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
    }

    .alert-danger {
        background: var(--danger-light);
        color: #c62828;
    }

    .alert ul {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .alert li {
        font-size: 14px;
    }

    .invalid-feedback {
        font-size: 13px;
        margin-top: 5px;
    }
</style>
@endpush

@section('content')
<main id="main" class="main">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-card">
                    <div class="form-header">
                        <h2 class="form-title">Form Pengajuan Cuti</h2>
                    </div>
                    
                    <div class="form-body">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('cuti.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" 
                                       class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" 
                                       name="tanggal_mulai" 
                                       value="{{ old('tanggal_mulai') }}"
                                       required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" 
                                       class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" 
                                       name="tanggal_selesai" 
                                       value="{{ old('tanggal_selesai') }}"
                                       required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="alasan" class="form-label">Alasan Cuti</label>
                                <textarea class="form-control @error('alasan') is-invalid @enderror" 
                                          id="alasan" 
                                          name="alasan" 
                                          rows="4" 
                                          required>{{ old('alasan') }}</textarea>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung (Optional)</label>
                                <input type="file" 
                                       class="form-control @error('dokumen_pendukung') is-invalid @enderror" 
                                       id="dokumen_pendukung" 
                                       name="dokumen_pendukung">
                                <small class="text-muted">File harus berformat PDF, JPG, JPEG, atau PNG (max 2MB)</small>
                                @error('dokumen_pendukung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check2-circle"></i> Submit Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#tanggal_mulai", {
        minDate: "today",
        dateFormat: "Y-m-d"
    });

    flatpickr("#tanggal_selesai", {
        minDate: "today",
        dateFormat: "Y-m-d"
    });
});
</script>
@endpush