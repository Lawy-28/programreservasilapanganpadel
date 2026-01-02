@extends('layout')

@section('content')

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header" style="justify-content: center; border-bottom: none;">
            <h2 class="card-title">Form Data Lapangan</h2>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger"
                style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 1rem; margin-bottom: 1rem; border-radius: 4px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lapangan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_lapangan">Nama Lapangan :</label>
                <input type="text" name="nama_lapangan" id="nama_lapangan" class="form-control" value="{{ old('nama_lapangan') }}" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori :</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <option value="VIP" {{ old('kategori') == 'VIP' ? 'selected' : '' }}>VIP</option>
                    <option value="Reguler" {{ old('kategori') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                </select>
            </div>

            <div class="form-group">
                <label for="harga_per_jam">Harga :</label>
                <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control" value="{{ old('harga_per_jam') }}" required>
            </div>

            <div class="form-group">
                <label for="status_lapangan">Status :</label>
                <select name="status_lapangan" class="form-control" required>
                    <option value="">Pilih Status</option>
                    <option value="Tersedia" {{ old('status_lapangan') == 'Tersedia' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="Perawatan" {{ old('status_lapangan') == 'Perawatan' ? 'selected' : '' }}>
                        Perawatan
                    </option>   
                </select>
            </div>

            <div class="form-actions" style="justify-content: flex-start;">
                <button type="submit" class="btn btn-primary"
                    style="background-color: #e0e0e0; border: 1px solid #ccc;">Simpan</button>
                <a href="{{ route('lapangan.index') }}" class="btn btn-primary"
                    style="background-color: #e0e0e0; border: 1px solid #ccc;">Kembali</a>
            </div>
        </form>
    </div>

@endsection