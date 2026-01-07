@extends('layout')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 fw-bold">Edit Data Lapangan</h5>
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

            <form action="{{ route('lapangan.update', $lapangan->id_lapangan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_lapangan" class="form-label fw-bold">Nama Lapangan :</label>
                <input type="text" name="nama_lapangan" id="nama_lapangan" class="form-control" value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}" required>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label fw-bold">Kategori :</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="VIP"
                        {{ strtolower(old('kategori', $lapangan->kategori)) == 'vip' ? 'selected' : '' }}>
                        VIP
                    </option>

                    <option value="Reguler"
                        {{ strtolower(old('kategori', $lapangan->kategori)) == 'reguler' ? 'selected' : '' }}>
                        Reguler
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="harga_per_jam" class="form-label fw-bold">Harga</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                    <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control" value="{{ old('harga_per_jam', $lapangan->harga_per_jam) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="status_lapangan" class="form-label fw-bold">Status</label>
                <select name="status_lapangan" id="status_lapangan" class="form-control" required>
                    <option value="Tersedia" {{ strtolower(old('status_lapangan', $lapangan->status_lapangan)) == 'tersedia' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="Perawatan" {{ strtolower(old('status_lapangan', $lapangan->status_lapangan)) == 'perawatan' ? 'selected' : '' }}>
                        Perawatan
                    </option>   
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

@endsection