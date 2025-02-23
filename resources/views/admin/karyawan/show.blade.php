<!-- filepath: /C:/laragon/www/pengajuan-cuti/resources/views/admin/karyawan/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Detail Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .detail-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid;
        }
        .stat-pending { border-left-color: #ffc107; }
        .stat-approved { border-left-color: #198754; }
        .stat-rejected { border-left-color: #dc3545; }
        .stat-total { border-left-color: #0d6efd; }
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }
        .stat-label {
            color: #6c757d;
            margin-bottom: 0;
        }
        .info-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #0d6efd;
    }
    .info-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .info-value {
        font-size: 1.1rem;
        color: #212529;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
    </style>
</head>
<body>
    @include('layouts.nav')
    
    <div class="container">
        <div class="detail-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Detail Karyawan</h2>
                @if(auth()->id() !== $karyawan->id)
                <div>
                    <button type="button" 
                            class="btn btn-warning"
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal">
                        Edit
                    </button>
                    <button type="button" 
                            class="btn btn-danger"
                            onclick="deleteKaryawan({{ $karyawan->id }})">
                        Delete
                    </button>
                </div>
                @endif
            </div>
    
            <!-- Employee Information Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="border-bottom pb-2 mb-4">Informasi Karyawan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-card">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value">{{ $karyawan->nama_karyawan ?? 'Belum diisi' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-card">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $karyawan->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-card">
                                <div class="info-label">Jabatan</div>
                                <div class="info-value">{{ $karyawan->jabatan->nama_jabatan ?? 'Belum diset' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-card">
                                <div class="info-label">No. Handphone</div>
                                <div class="info-value">{{ $karyawan->nohp ?? 'Belum diisi' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-card">
                                <div class="info-label">Status Akun</div>
                                <div class="info-value">
                                    <span class="badge {{ $karyawan->is_verified ? 'bg-success' : 'bg-danger' }}">
                                        {{ $karyawan->is_verified ? 'Verified' : 'Unverified' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-card">
                                <div class="info-label">Role</div>
                                <div class="info-value">
                                    <span class="badge bg-{{ $karyawan->role === 'admin' ? 'danger' : 'info' }}">
                                        {{ ucfirst($karyawan->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Leave History Section -->
            <div class="row">
                <div class="col-12">
                    <h5 class="border-bottom pb-2 mb-4">Riwayat Cuti</h5>
                </div>
                <div class="col-md-4">
                    <div class="stat-card stat-total">
                        <p class="stat-number">{{ $karyawan->cutis->count() }}</p>
                        <p class="stat-label">Total Pengajuan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card stat-approved">
                        <p class="stat-number">{{ $karyawan->cutis->where('status', 'approved')->count() }}</p>
                        <p class="stat-label">Disetujui</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card stat-rejected">
                        <p class="stat-number">{{ $karyawan->cutis->where('status', 'rejected')->count() }}</p>
                        <p class="stat-label">Ditolak</p>
                    </div>
                </div>
            </div>
    
            <div class="mt-4">
                <a href="{{ route('admin.add-email') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.update-karyawan', $karyawan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   name="is_verified" 
                                   id="verify"
                                   {{ $karyawan->is_verified ? 'checked' : '' }}>
                            <label class="form-check-label">Verified</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="karyawan" {{ $karyawan->role === 'karyawan' ? 'selected' : '' }}>
                                Karyawan
                            </option>
                            <option value="admin" {{ $karyawan->role === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <select class="form-select" name="jabatan_id" required>
                            @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}" 
                                    {{ $karyawan->jabatan_id == $jabatan->id ? 'selected' : '' }}>
                                    {{ $jabatan->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteKaryawan(id) {
            if(confirm('Apakah Anda yakin ingin menghapus karyawan ini?')) {
                fetch(`/admin/karyawan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.href = '{{ route("admin.add-email") }}';
                    }
                });
            }
        }
    </script>
</body>
</html>