@extends('layouts.template.app')

@section('title', 'Detail Pengajuan Cuti')

@push('css')
    <style>
        :root {
            --primary-light: #e3f2fd;
            --primary-main: #2196f3;
            --primary-dark: #1e88e5;
        }

        .main {
            margin-top: 30px;
            padding: 20px 30px;
        }

        .section {
            background: #f6f9ff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        }

        .pagetitle {
            margin-bottom: 20px;
        }

        .pagetitle h1 {
            font-size: 24px;
            font-weight: 600;
            color: #012970;
        }

        .breadcrumb {
            font-size: 14px;
            font-family: "Nunito", sans-serif;
            color: #899bbd;
            font-weight: 600;
        }

        .detail-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(1, 41, 112, 0.1);
            margin-bottom: 30px;
        }

        .detail-card .card-header {
            background: linear-gradient(to right, var(--primary-light), #ffffff);
            padding: 20px 30px;
            border-radius: 15px 15px 0 0;
            border-bottom: 2px solid rgba(33, 150, 243, 0.1);
        }

        .detail-card .card-body {
            padding: 30px;
        }

        .info-group {
            margin-bottom: 2.5rem;
            background: #f6f9ff;
            padding: 20px;
            border-radius: 10px;
        }

        .info-group h5 {
            color: #012970;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e8f9;
        }

        .info-group h5 i {
            margin-right: 8px;
            color: var(--primary-main);
        }

        .info-item {
            margin-bottom: 1rem;
            padding: 8px 0;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-item strong {
            color: #012970;
            min-width: 160px;
            display: inline-block;
            font-weight: 600;
        }

        .badge {
            padding: 8px 15px;
            font-weight: 500;
            font-size: 0.85rem;
            border-radius: 20px;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(1, 41, 112, 0.2);
        }

        .action-form {
            background: #f6f9ff;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #e0e8f9;
        }

        .action-form h5 {
            color: #012970;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-label {
            color: #012970;
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border-color: #e0e8f9;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-main);
        }

        .info-group.alasan-cuti {
            background: #fff8e1;
            border: 1px solid #ffe082;
        }

        .info-group.alasan-cuti h5 {
            color: #ff8f00;
            border-bottom-color: #ffe082;
        }

        .info-group.alasan-cuti h5 i {
            color: #ffa000;
        }

        .action-form.reject-form {
            background: #ffebee;
            border: 1px solid #ffcdd2;
        }

        .action-form.reject-form h5 {
            color: #c62828;
        }

        .action-form.reject-form .form-label {
            color: #d32f2f;
        }

        .action-form.reject-form .form-control {
            border-color: #ffcdd2;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .action-form.reject-form .form-control:focus {
            border-color: #ef5350;
            background-color: #fff;
        }

        .action-form.approve-form {
            background: #e8f5e9;
            border: 1px solid #c8e6c9;
        }

        .action-form.approve-form h5 {
            color: #2e7d32;
        }

        .action-form.approve-form .form-label {
            color: #388e3c;
        }

        .action-form.approve-form .form-control {
            border-color: #c8e6c9;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .info-group.status-approved {
            background: #e8f5e9;
            border: 1px solid #c8e6c9;
        }

        .info-group.status-approved h5 {
            color: #2e7d32;
            border-bottom-color: #c8e6c9;
        }

        .info-group.status-approved h5 i {
            color: #43a047;
        }

        .info-group.status-rejected {
            background: #ffebee;
            border: 1px solid #ffcdd2;
        }

        .info-group.status-rejected h5 {
            color: #c62828;
            border-bottom-color: #ffcdd2;
        }

        .info-group.status-rejected h5 i {
            color: #d32f2f;
        }

        .document-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: #f8f9fa;
            border-radius: 8px;
            color: var(--secondary-main);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .document-link:hover {
            background: var(--primary-light);
            color: var(--primary-main);
            transform: translateY(-2px);
        }

        .document-link i {
            margin-right: 8px;
        }
    </style>
@endpush

@section('content')
    <main id="main" class="main">

        <section class="section">
            <div class="detail-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Pengajuan</h5>
                    <span
                        class="badge bg-{{ $cuti->status === 'pending' ? 'warning' : ($cuti->status === 'approved' ? 'success' : 'danger') }}">
                        {{ ucfirst($cuti->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group">
                                <h5><i class="bi bi-person"></i> Data Karyawan</h5>
                                <div class="info-item">
                                    <strong>Nama:</strong> {{ $cuti->karyawan->nama_karyawan }}
                                </div>
                                <div class="info-item">
                                    <strong>Email:</strong> {{ $cuti->karyawan->email }}
                                </div>
                                <div class="info-item">
                                    <strong>Jabatan:</strong> {{ $cuti->karyawan->jabatan->nama_jabatan }}
                                </div>
                                <div class="info-item">
                                    <strong>Kelamin:</strong>  {{ $cuti->karyawan->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <h5><i class="bi bi-calendar-event"></i> Detail Cuti</h5>
                                <div class="info-item">
                                    <strong>Jenis Cuti:</strong> 
                                    @php
                                        $jenisLabels = [
                                            'tahunan' => 'Cuti Tahunan',
                                            'khusus' => 'Cuti Khusus',
                                            'haid' => 'Cuti Haid',
                                            'melahirkan' => 'Cuti Melahirkan',
                                            'ayah' => 'Cuti Ayah'
                                        ];
                                    @endphp
                                    {{ $jenisLabels[$cuti->jenis_cuti] }}
                                </div>
                                <div class="info-item">
                                    <strong>Tanggal Mulai:</strong>
                                    {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }}
                                </div>
                                <div class="info-item">
                                    <strong>Tanggal Selesai:</strong>
                                    {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}
                                </div>
                                <div class="info-item">
                                    <strong>Jumlah Hari:</strong> {{ $cuti->jumlah_hari }} hari
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-group alasan-cuti">
                        <h5><i class="bi bi-chat-text"></i> Alasan Cuti</h5>
                        <p class="mb-0">{{ $cuti->alasan }}</p>
                    </div>

                    @if ($cuti->dokumen_pendukung)
                        <div class="mb-4">
                            <label class="info-label d-block mb-2">Dokumen Pendukung:</label>
                            <a href="{{ asset('storage/dokumen_pendukung/' . $cuti->dokumen_pendukung) }}"
                                class="document-link" target="_blank">
                                <i class="bi bi-file-earmark-text"></i>
                                Lihat Dokumen
                            </a>
                        </div>
                    @endif

                    @if ($cuti->status === 'pending')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="action-form approve-form">
                                    <h5 class="mb-3">Approve Pengajuan</h5>
                                    <form action="{{ route('admin.cuti.approve', $cuti) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan (Optional)</label>
                                            <textarea class="form-control" name="keterangan_status" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="action-form reject-form">
                                    <h5 class="mb-3">Reject Pengajuan</h5>
                                    <form action="{{ route('admin.cuti.reject', $cuti) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Penolakan</label>
                                            <textarea class="form-control" name="keterangan_status" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="info-group status-{{ $cuti->status }}">
                            <h5><i class="bi bi-info-circle"></i> Keterangan Status</h5>
                            <p class="mb-0">{{ $cuti->keterangan_status ?: 'Tidak ada keterangan' }}</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
