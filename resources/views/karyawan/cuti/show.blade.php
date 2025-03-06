@extends('layouts.template.app')

@section('title', 'Detail Pengajuan Cuti')

@push('css')
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

        .detail-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
            margin-bottom: 30px;
            border: none;
            overflow: hidden;
        }

        .detail-header {
            background: linear-gradient(to right, var(--primary-light), #ffffff);
            padding: 25px 30px;
            border-bottom: 2px solid rgba(33, 150, 243, 0.1);
        }

        .detail-title {
            color: var(--secondary-main);
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .detail-body {
            padding: 30px;
        }

        .section-title {
            color: var(--secondary-main);
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-light);
        }

        .info-label {
            color: #6c757d;
            font-weight: 500;
            font-size: 14px;
        }

        .info-value {
            color: var(--secondary-main);
            font-weight: 600;
            font-size: 15px;
        }

        .status-badge {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 30px;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: var(--warning-light);
            color: var(--warning-main);
        }

        .status-approved {
            background: var(--success-light);
            color: var(--success-main);
        }

        .status-rejected {
            background: var(--danger-light);
            color: var(--danger-main);
        }

        .btn {
            padding: 10px 20px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
        }

        .btn-danger {
            background: var(--danger-main);
            border: none;
            box-shadow: 0 4px 12px rgba(239, 83, 80, 0.2);
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

        .reason-text {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            color: #444444;
            font-size: 14px;
            line-height: 1.6;
        }

        .status-note {
            background: var(--primary-light);
            padding: 15px;
            border-radius: 8px;
            color: var(--secondary-main);
            font-size: 14px;
            line-height: 1.6;
            margin-top: 20px;
        }

        /* Add these styles to your existing CSS */
        .detail-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
            border: none;
            overflow: hidden;
            height: 100%;
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(1, 41, 112, 0.15);
        }

        .detail-header {
            background: linear-gradient(to right, var(--primary-light), #ffffff);
            padding: 20px 25px;
            border-bottom: 2px solid rgba(33, 150, 243, 0.1);
        }

        .detail-body {
            padding: 25px;
        }

        .section-title {
            color: var(--secondary-main);
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 0;
        }

        dl.row:last-child {
            margin-bottom: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        .reason-text {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            color: #444444;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 0;
        }
    </style>
@endpush

@section('content')
    <main id="main" class="main">
        <div class="container py-4">
            <div class="row">
                <!-- Info Card -->
                <div class="col-md-6 mb-4">
                    <div class="detail-card">
                        <div class="detail-header">
                            <h5 class="section-title mb-0">Informasi Pengajuan</h5>
                        </div>
                        <div class="detail-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-4 info-label">Tanggal Mulai</dt>
                                <dd class="col-sm-8 info-value">{{ $cuti->tanggal_mulai->format('d F Y') }}</dd>

                                <dt class="col-sm-4 info-label">Tanggal Selesai</dt>
                                <dd class="col-sm-8 info-value">{{ $cuti->tanggal_selesai->format('d F Y') }}</dd>

                                <dt class="col-sm-4 info-label">Jumlah Hari</dt>
                                <dd class="col-sm-8 info-value">{{ $cuti->jumlah_hari }} hari</dd>

                                <dt class="col-sm-4 info-label">Tanggal Pengajuan</dt>
                                <dd class="col-sm-8 info-value">{{ $cuti->created_at->format('d F Y H:i') }}</dd>

                                <dt class="col-sm-4 info-label">Status</dt>
                                <dd class="col-sm-8">
                                    <span class="status-badge status-{{ $cuti->status }}">
                                        {{ ucfirst($cuti->status) }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Detail Card -->
                <div class="col-md-6 mb-4">
                    <div class="detail-card">
                        <div class="detail-header">
                            <h5 class="section-title mb-0">Detail Pengajuan</h5>
                        </div>
                        <div class="detail-body">
                            <div class="mb-4">
                                <label class="info-label d-block mb-2">Alasan Cuti:</label>
                                <div class="reason-text">{{ $cuti->alasan }}</div>
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

                            @if ($cuti->keterangan_status)
                                <div class="status-note">
                                    <strong class="d-block mb-2">Keterangan {{ ucfirst($cuti->status) }}:</strong>
                                    {{ $cuti->keterangan_status }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="detail-card">
                <div class="detail-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        @if ($cuti->status === 'pending')
                            <button type="button" class="btn btn-danger" onclick="deleteCuti({{ $cuti->id }})">
                                <i class="bi bi-trash"></i> Hapus Pengajuan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function deleteCuti(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengajuan cuti ini?')) {
                fetch(`/cuti/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.href = '{{ route('karyawan.dashboard') }}';
                    }
                }).catch(error => {
                    alert('Terjadi kesalahan saat menghapus pengajuan cuti.');
                    console.error('Error:', error);
                });
            }
        }
    </script>
@endpush
