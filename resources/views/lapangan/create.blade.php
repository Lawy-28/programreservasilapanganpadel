@extends('layout')

@section('content')

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 fw-bold">Tambah Lapangan Baru</h5>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

             <form action="{{ route('lapangan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_lapangan" class="form-label fw-bold">Nama Lapangan</label>
                <input type="text" name="nama_lapangan" id="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Lapangan Padel VIP 1" required>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label fw-bold">Kategori</label>
                <select name="kategori" id="kategori" class="form-select" required>
                    <option value="#">Pilih Kategori</option>
                    <option value="VIP" {{ old('kategori') == 'VIP' ? 'selected' : '' }}>VIP</option>
                    <option value="Reguler" {{ old('kategori') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="harga_per_jam" class="form-label fw-bold">Harga</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                    <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control" value="{{ old('harga_per_jam') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="status_lapangan" class="form-label fw-bold">Status</label>
                <select name="status_lapangan" id="status_lapangan" class="form-select" required>
                    <option value="#">Pilih Status</option>
                    <option value="Tersedia" {{ old('status_lapangan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Perawatan" {{ old('status_lapangan') == 'Perawatan' ? 'selected' : '' }}>Perawatan</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save me-1"></i> Simpan Data
                </button>
                <a href="{{ route('lapangan.index') }}" class="btn btn-light border px-4">
                    Batal
                </a>    
            </div>  
        </form>
        </div>
    </div>
@endsection