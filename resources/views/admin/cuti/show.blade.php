<!-- filepath: /c:/laragon/www/pengajuan-cuti/resources/views/admin/cuti/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengajuan Cuti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .detail-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    @include('layouts.nav')
    
    <div class="container py-4">
        <div class="detail-container">
            <h2 class="mb-4">Detail Pengajuan Cuti</h2>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informasi Karyawan</h5>
                    <p><strong>Nama:</strong> {{ $cuti->karyawan->nama_karyawan }}</p>
                    <p><strong>Email:</strong> {{ $cuti->karyawan->email }}</p>
                    <p><strong>Jabatan:</strong> {{ $cuti->karyawan->jabatan->nama_jabatan }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Cuti</h5>
                    <p><strong>Tanggal Mulai:</strong> {{ $cuti->tanggal_mulai }}</p>
                    <p><strong>Tanggal Selesai:</strong> {{ $cuti->tanggal_selesai }}</p>
                    <p><strong>Jumlah Hari:</strong> {{ $cuti->jumlah_hari }} hari</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $cuti->status === 'pending' ? 'warning' : ($cuti->status === 'approved' ? 'success' : 'danger') }}">
                            {{ ucfirst($cuti->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <h5>Alasan Cuti</h5>
                <p>{{ $cuti->alasan }}</p>
            </div>

            @if($cuti->dokumen_pendukung)
            <div class="mb-4">
                <h5>Dokumen Pendukung</h5>
                <a href="{{ asset('storage/dokumen_pendukung/' . $cuti->dokumen_pendukung) }}" 
                   class="btn btn-sm btn-secondary" 
                   target="_blank">
                    Lihat Dokumen
                </a>
            </div>
            @endif

            @if($cuti->status === 'pending')
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.cuti.approve', $cuti) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="keterangan_approve" class="form-label">Keterangan (Optional)</label>
                            <textarea class="form-control" id="keterangan_approve" name="keterangan_status" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('admin.cuti.reject', $cuti) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="keterangan_reject" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" id="keterangan_reject" name="keterangan_status" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
            </div>
            @else
            <div class="mb-4">
                <h5>Keterangan Status</h5>
                <p>{{ $cuti->keterangan_status ?: 'Tidak ada keterangan' }}</p>
            </div>
            @endif

            <a href="{{ route('admin.cuti.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>