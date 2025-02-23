<!DOCTYPE html>
<html>
<head>
    <title>List Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .badge-verified {
            background-color: #198754;
        }
        .badge-unverified {
            background-color: #dc3545;
        }
        .badge-admin {
        background-color: #dc3545;
    }
    .badge-karyawan {
        background-color: #0dcaf0;
    }
    </style>
</head>
<body>
    @include('layouts.nav')
    
    <div class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Daftar Email Karyawan</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmailModal">
                    Tambah Karyawan
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Add Email Modal -->
            <div class="modal fade" id="addEmailModal" tabindex="-1" aria-labelledby="addEmailModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEmailModalLabel">Tambah Email Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.store-email') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    <input type="text" 
                                           class="form-control @error('nama_karyawan') is-invalid @enderror" 
                                           id="nama_karyawan" 
                                           name="nama_karyawan" 
                                           value="{{ old('nama_karyawan') }}" 
                                           required>
                                    @error('nama_karyawan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jabatan_id" class="form-label">Jabatan</label>
                                    <select class="form-select @error('jabatan_id') is-invalid @enderror" 
                                            id="jabatan_id" 
                                            name="jabatan_id" 
                                            required>
                                        <option value="">Pilih Jabatan</option>
                                        @foreach($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}" 
                                                {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                                {{ $jabatan->nama_jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Error Modal -->
            @if($errors->any())
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="errorModalLabel">Error</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-unstyled mb-0">
                                @foreach($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="table-responsive">
                <table id="karyawanTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawans as $index => $karyawan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $karyawan->nama_karyawan ?? 'Belum diisi' }}</td>
                            <td>{{ $karyawan->email }}</td>
                            <td>{{ $karyawan->jabatan->nama_jabatan ?? 'Belum diset' }}</td>
                            <td>
                                <span class="badge {{ $karyawan->is_verified ? 'badge-verified' : 'badge-unverified' }}">
                                    {{ $karyawan->is_verified ? 'Verified' : 'Unverified' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $karyawan->role === 'admin' ? 'danger' : 'info' }}">
                                    {{ ucfirst($karyawan->role) }}
                                </span>
                            </td>
                            <td>
                                @if(auth()->id() !== $karyawan->id)
                                    <a href="{{ route('admin.karyawan.show', $karyawan->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Current User</span>
                                @endif
                            </td>
                        </tr>


                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Wait for document ready
    $(document).ready(function() {
        $('#karyawanTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data",
                "search": "Cari:",
                "zeroRecords": "Tidak ditemukan"
            },
            "pageLength": 10,
            "searching": true,
            "paging": true,
            "info": false,
            "ordering": false
        });
    });

    // Delete function
    function deleteKaryawan(id) {
    if(id === {{ auth()->id() }}) {
        alert('Tidak dapat menghapus akun sendiri!');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin menghapus karyawan ini?')) {
        fetch(`/admin/karyawan/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}

    // Error modal handler
    @if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    });
    @endif
</script>
</body>
</html>