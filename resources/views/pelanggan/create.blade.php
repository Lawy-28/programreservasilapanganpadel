@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Tambah Pelanggan</h2>
        </div>

        @if ($errors->any())
            <div class="alert" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>

            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="number" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email <small>(Opsional)</small></label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Simpan Data</button>
                <a href="{{ route('pelanggan.index') }}" class="btn" style="background-color: #ccc;">Batal</a>
            </div>
        </form>
    </div>
@endsection