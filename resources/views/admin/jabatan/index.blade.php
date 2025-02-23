<!-- filepath: /C:/laragon/www/pengajuan-cuti/resources/views/admin/jabatan/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
    @include('layouts.nav')
    
    <div class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Daftar Jabatan</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJabatanModal">
                    Tambah Jabatan
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama Jabatan</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jabatans as $index => $jabatan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $jabatan->nama_jabatan }}</td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $jabatan->id }}">
                                        Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteJabatan({{ $jabatan->id }})">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $jabatan->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Jabatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.jabatan.update', $jabatan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Jabatan</label>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="nama_jabatan" 
                                                           value="{{ $jabatan->nama_jabatan }}" 
                                                           required>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Jabatan Modal -->
    <div class="modal fade" id="createJabatanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jabatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.jabatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Jabatan</label>
                            <input type="text" 
                                   class="form-control @error('nama_jabatan') is-invalid @enderror" 
                                   name="nama_jabatan" 
                                   required>
                            @error('nama_jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Jabatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteJabatan(id) {
            if(confirm('Apakah Anda yakin ingin menghapus jabatan ini?')) {
                fetch(`/admin/jabatan/${id}`, {
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

        @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            var createModal = new bootstrap.Modal(document.getElementById('createJabatanModal'));
            createModal.show();
        });
        @endif
    </script>
</body>
</html>