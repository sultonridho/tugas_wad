<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f6f8;
            color: #292d32;
            font-family: Arial, Helvetica, sans-serif;
        }
        .navbar-brand { font-weight: 600; letter-spacing: .1px; }
        .page-wrap { max-width: 1180px; }
        .page-title { font-size: 1.45rem; font-weight: 600; }
        .subtle { color: #737b84; font-size: .92rem; }
        .card {
            border: 1px solid #e7e9ed;
            border-radius: 8px;
            box-shadow: 0 2px 7px rgba(25, 35, 45, .035);
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #eceef1;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }
        .card-body { padding: 1.25rem; }
        .form-label { font-size: .9rem; font-weight: 600; margin-bottom: .4rem; }
        .form-control, .form-select { min-height: 41px; border-color: #d9dde2; }
        .form-control:focus, .form-select:focus {
            border-color: #7aa7e8;
            box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .1);
        }
        .btn { border-radius: 5px; }
        .table { margin-bottom: 0; }
        .table thead th {
            background: #f7f8fa;
            color: #515963;
            font-size: .82rem;
            font-weight: 600;
            white-space: nowrap;
            border-bottom: 1px solid #e4e7eb;
            padding: .85rem .9rem;
        }
        .table tbody td { padding: .85rem .9rem; vertical-align: middle; }
        .table tbody tr:last-child td { border-bottom: 0; }
        .status-badge { font-size: .78rem; font-weight: 600; }
        .empty-state { padding: 2.5rem 1rem !important; color: #737b84; }
        @media (max-width: 576px) {
            .card-body, .card-header { padding: 1rem; }
            .page-title { font-size: 1.25rem; }
        }
    </style>
</head>
<body>

    <main class="container page-wrap py-4 py-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
            <div>
                <h1 class="page-title mb-1">Driver / Pengemudi</h1>
                <p class="subtle mb-0">Kelola informasi dan status pengemudi.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <div class="fw-semibold mb-1">Periksa kembali data yang dimasukkan:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card mb-4">
            <div class="card-header">
                {{ isset($editDriver) && $editDriver ? 'Edit Data Driver' : 'Tambah Data Driver' }}
            </div>
            <div class="card-body">
                <form
                    action="{{ isset($editDriver) && $editDriver ? route('drivers.update', $editDriver->id) : route('drivers.store') }}"
                    method="POST">
                    @csrf
                    @if (isset($editDriver) && $editDriver)
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nama" class="form-label">Nama Driver</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                   value="{{ old('nama', $editDriver->nama ?? '') }}" placeholder="Masukkan nama driver" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="umur" class="form-label">Umur</label>
                            <input type="number" class="form-control" id="umur" name="umur" min="1"
                                   value="{{ old('umur', $editDriver->umur ?? '') }}" placeholder="Masukkan umur" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="pengalaman_pengemudi" class="form-label">Pengalaman Mengemudi (tahun)</label>
                            <input type="number" class="form-control" id="pengalaman_pengemudi" name="pengalaman_pengemudi" min="0"
                                   value="{{ old('pengalaman_pengemudi', $editDriver->pengalaman_pengemudi ?? '') }}" placeholder="Lama pengalaman mengemudi" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="nomor_sim_aktif" class="form-label">Nomor SIM Aktif</label>
                            <input type="text" class="form-control" id="nomor_sim_aktif" name="nomor_sim_aktif"
                                   value="{{ old('nomor_sim_aktif', $editDriver->nomor_sim_aktif ?? '') }}" placeholder="Masukkan nomor SIM" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="kontak" name="kontak"
                                   value="{{ old('kontak', $editDriver->kontak ?? '') }}" placeholder="Nomor telepon atau kontak" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Pilih status</option>
                                <option value="Aktif" {{ old('status', $editDriver->status ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status', $editDriver->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="submit" class="btn btn-success px-3">
                            {{ isset($editDriver) && $editDriver ? 'Simpan Perubahan' : 'Tambah Driver' }}
                        </button>
                        @if (isset($editDriver) && $editDriver)
                            <a href="{{ route('drivers.index') }}" class="btn btn-outline-secondary">Batal</a>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <section class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-2">
                <span>Daftar Driver</span>
                <span class="badge text-bg-light border">{{ $drivers->count() }} data</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Umur</th>
                            <th>Pengalaman</th>
                            <th>Nomor SIM</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($drivers as $driver)
                            <tr>
                                <td class="text-secondary">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $driver->nama }}</td>
                                <td>{{ $driver->umur }} th</td>
                                <td>{{ $driver->pengalaman_pengemudi }} tahun</td>
                                <td>{{ $driver->nomor_sim_aktif }}</td>
                                <td>{{ $driver->kontak }}</td>
                                <td>
                                    @if ($driver->status === 'Aktif')
                                        <span class="badge rounded-pill text-bg-success status-badge">Aktif</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-secondary status-badge">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data driver ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center empty-state">
                                    Belum ada data driver. Silakan tambahkan data melalui formulir di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    
<footer class="text-center py-3 mt-4 border-top">
    <small class="text-muted">
        &copy; {{ date('Y') }} Cuki Sulton Gemink. All rights reserved.
    </small>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
