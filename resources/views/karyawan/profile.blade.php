<!DOCTYPE html>
<html>

<head>
    <title>Complete Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-container">
            <h2 class="profile-title">Complete Your Profile</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('karyawan.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_karyawan" class="form-label">Nama Karyawan:</label>
                    <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror"
                        name="nama_karyawan" id="nama_karyawan"
                        value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" maxlength="25">
                    @error('nama_karyawan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" value="{{ $karyawan->email }}" disabled>
                    <small class="text-muted">Email cannot be changed</small>
                </div>

                <div class="mb-3">
                    <label for="nohp" class="form-label">No. HP:</label>
                    <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp"
                        id="nohp" value="{{ old('nohp', $karyawan->nohp) }}" maxlength="20">
                    @error('nohp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jabatan_id" class="form-label">Jabatan:</label>
                    <input type="text" class="form-control" value="{{ $karyawan->jabatan->nama_jabatan ?? '' }}"
                        disabled>
                    <small class="text-muted">Jabatan cannot be changed</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>

            <div class="d-grid gap-2 mt-3">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                @else
                    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif
</body>

</html>
