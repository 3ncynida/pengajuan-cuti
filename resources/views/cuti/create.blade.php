<!-- filepath: /c:/laragon/www/pengajuan-cuti/resources/views/cuti/create.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Cuti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Form Pengajuan Cuti</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('cuti.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" 
                           class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                           id="tanggal_mulai" 
                           name="tanggal_mulai" 
                           value="{{ old('tanggal_mulai') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" 
                           class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                           id="tanggal_selesai" 
                           name="tanggal_selesai" 
                           value="{{ old('tanggal_selesai') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan Cuti</label>
                    <textarea class="form-control @error('alasan') is-invalid @enderror" 
                              id="alasan" 
                              name="alasan" 
                              rows="3" 
                              required>{{ old('alasan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung (Optional)</label>
                    <input type="file" 
                           class="form-control @error('dokumen_pendukung') is-invalid @enderror" 
                           id="dokumen_pendukung" 
                           name="dokumen_pendukung">
                    <small class="text-muted">File harus berformat PDF, JPG, JPEG, atau PNG (max 2MB)</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Submit Pengajuan</button>
                    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#tanggal_mulai", {
                minDate: "today",
                dateFormat: "Y-m-d"
            });

            flatpickr("#tanggal_selesai", {
                minDate: "today",
                dateFormat: "Y-m-d"
            });
        });
    </script>
</body>
</html>