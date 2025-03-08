@extends('layouts.template.app')

@section('title', 'Detail Karyawan')

@push('css')
<style>
    :root {
        --primary-light: #bfe1fa;
        --primary-main: #2196f3;
        --primary-dark: #1e88e5;
        --warning-light: #fff8e1;
        --warning-main: #ffa000;
        --success-light: #e8f5e9;
        --success-main: #b4eeb6;
        --danger-light: #f1b5be;
        --danger-main: #e44441;
        --secondary-main: #012970;
    }

    .main {
        margin-top: 60px;
        padding: 20px 30px;
        background: #f6f9ff;
        min-height: calc(100vh - 60px);
    }

    .section {
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
    }

    .card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
        margin-bottom: 30px;
        border: none;
    }

    .card-header {
        background: linear-gradient(to right, var(--primary-light), #ffffff);
        padding: 25px 30px;
        border-radius: 20px 20px 0 0;
        border-bottom: 2px solid rgba(33, 150, 243, 0.1);
    }

    .card-title {
        color: var(--secondary-main);
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 0.3px;
        margin: 0;
    }

    .card-body {
        padding: 30px;
        border-radius: 20px;
    }

    .info-card {
        background: #fff;
        padding: 25px;
        border-radius: 20px;
        margin-bottom: 20px;
        border: 1px solid rgba(1, 41, 112, 0.1);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
    }

    .info-label {
        color: var(--secondary-main);
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 10px;
        letter-spacing: 0.3px;
    }

    .info-value {
        color: #444444;
        font-size: 16px;
        font-weight: 500;
    }

    .stat-card {
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        border: none;
    }

    .stat-pending {
        background: linear-gradient(135deg, var(--warning-light) 0%, #ffffff 100%);
        box-shadow: 0 5px 20px rgba(255, 160, 0, 0.1);
    }

    .stat-approved {
        background: linear-gradient(135deg, var(--success-main) 0%, #ffffff 100%);
        box-shadow: 0 5px 20px rgba(76, 175, 80, 0.1);
    }

    .stat-rejected {
        background: linear-gradient(135deg, var(--danger-light) 0%, #ffffff 100%);
        box-shadow: 0 5px 20px rgba(239, 83, 80, 0.1);
    }

    .stat-total {
        background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
        box-shadow: 0 5px 20px rgba(33, 150, 243, 0.1);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--secondary-main);
    }

    .stat-label {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
    }

    .badge {
        padding: 8px 16px;
        font-weight: 500;
        font-size: 13px;
        border-radius: 20px;
        letter-spacing: 0.3px;
    }

    .btn {
        padding: 8px 20px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: var(--primary-main);
        border: none;
        box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);
    }

    .btn-danger {
        background: var(--danger-main);
        border: none;
        box-shadow: 0 4px 12px rgba(239, 83, 80, 0.2);
    }

    .btn-warning {
        background: var(--warning-main);
        border: none;
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 160, 0, 0.2);
    }

    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(to right, var(--primary-light), #ffffff);
        padding: 20px 25px;
        border-bottom: 2px solid rgba(33, 150, 243, 0.1);
    }

    .modal-title {
        color: var(--secondary-main);
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .form-label {
        color: var(--secondary-main);
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 18px;
        border-color: #e0e8f9;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        border-color: var(--primary-main);
        background: #fff;
    }
    .btn-close {
        transition: transform 0.3s ease;
    }

    .btn-close:hover {
        transform: rotate(90deg);
    }
</style>
@endpush
@section('content')
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Detail Karyawan</h5>
                @if(auth()->id() !== $karyawan->id)
                <div>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger" onclick="deleteKaryawan({{ $karyawan->id }})">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
                @endif
            </div>
            <div class="card-body">
            <!-- Employee Information Section -->
            <div class="row mb-4">
                <div class="col-12">
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
            @if($karyawan->role === 'karyawan')
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
        @endif
    
        <div class="mt-4">
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
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
                        window.location.href = '{{ route("admin.karyawan.index") }}';
                    }
                });
            }
        }
    </script>
 </section>
</main>
@endsection