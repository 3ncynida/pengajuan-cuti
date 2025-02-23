<!-- filepath: /c:/laragon/www/pengajuan-cuti/resources/views/cuti/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengajuan Cuti</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .detail-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .status-badge {
            font-size: 1rem;
            padding: 8px 16px;
        }
    </style>
</head>
<body>
    @include('layouts.nav')

    <div class="container">
        <div class="detail-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Detail Pengajuan Cuti</h2>
                <span class="badge status-badge bg-{{ $cuti->status === 'pending' ? 'warning' : ($cuti->status === 'approved' ? 'success' : 'danger') }}">
                    {{ ucfirst($cuti->status) }}
                </span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Informasi Pengajuan</h5>
                        <dl class="row">
                            <dt class="col-sm-4">Tanggal Mulai</dt>
                            <dd class="col-sm-8">{{ $cuti->tanggal_mulai->format('d F Y') }}</dd>

                            <dt class="col-sm-4">Tanggal Selesai</dt>
                            <dd class="col-sm-8">{{ $cuti->tanggal_selesai->format('d F Y') }}</dd>

                            <dt class="col-sm-4">Jumlah Hari</dt>
                            <dd class="col-sm-8">{{ $cuti->jumlah_hari }} hari</dd>

                            <dt class="col-sm-4">Tanggal Pengajuan</dt>
                            <dd class="col-sm-8">{{ $cuti->created_at->format('d F Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Detail Pengajuan</h5>
                        <div class="mb-3">
                            <strong>Alasan Cuti:</strong>
                            <p class="mt-2">{{ $cuti->alasan }}</p>
                        </div>

                        @if($cuti->dokumen_pendukung)
                        <div class="mb-3">
                            <strong>Dokumen Pendukung:</strong><br>
                            <a href="{{ asset('storage/dokumen_pendukung/' . $cuti->dokumen_pendukung) }}" 
                               class="btn btn-sm btn-secondary mt-2" 
                               target="_blank">
                                <i class="fas fa-file-download"></i> Lihat Dokumen
                            </a>
                        </div>
                        @endif

                        @if($cuti->keterangan_status)
                        <div class="mt-4">
                            <h5 class="border-bottom pb-2">Keterangan {{ ucfirst($cuti->status) }}</h5>
                            <p class="mt-2">{{ $cuti->keterangan_status }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                    
                    @if($cuti->status === 'pending')
                        <button type="button" 
                                class="btn btn-danger" 
                                onclick="deleteCuti({{ $cuti->id }})">
                            <i class="fas fa-trash"></i> Hapus Pengajuan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                        window.location.href = '{{ route("karyawan.dashboard") }}';
                    } else {
                        response.json().then(data => {
                            alert(data.error || 'Terjadi kesalahan saat menghapus pengajuan cuti.');
                        });
                    }
                }).catch(error => {
                    alert('Terjadi kesalahan saat menghapus pengajuan cuti.');
                    console.error('Error:', error);
                });
            }
        }
        </script>
</body>
</html>