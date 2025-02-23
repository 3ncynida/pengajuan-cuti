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

            <div class="row">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Karyawan</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ $karyawan->nama_karyawan ?? 'Belum diisi' }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $karyawan->email }}</dd>

                        <dt class="col-sm-4">Jabatan</dt>
                        <dd class="col-sm-8">{{ $karyawan->jabatan->nama_jabatan ?? 'Belum diset' }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ $karyawan->is_verified ? 'bg-success' : 'bg-danger' }}">
                                {{ $karyawan->is_verified ? 'Verified' : 'Unverified' }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Role</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-{{ $karyawan->role === 'admin' ? 'danger' : 'info' }}">
                                {{ ucfirst($karyawan->role) }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.add-email') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
<!-- filepath: /C:/laragon/www/pengajuan-cuti/resources/views/admin/karyawan/show.blade.php -->
<!-- Replace the existing edit modal content -->
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