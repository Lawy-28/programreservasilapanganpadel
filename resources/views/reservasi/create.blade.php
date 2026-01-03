@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Buat Reservasi Baru</h2>
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

        <form action="{{ route('reservasi.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="id_pelanggan">Pelanggan</label>
                <select name="id_pelanggan" id="id_pelanggan" class="form-control" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->id_pelanggan }}">{{ $p->nama }} ({{ $p->no_hp }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_lapangan">Lapangan</label>
                <select name="id_lapangan" id="id_lapangan" class="form-control" required>
                    <option value="">-- Pilih Lapangan --</option>
                    @foreach($lapangan as $l)
                        <option value="{{ $l->id_lapangan }}">
                            {{ $l->nama_lapangan }} (Rp {{ number_format($l->harga_per_jam, 0, ',', '.') }}/jam)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Main</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
            </div>

            <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                <small style="margin-left: 10px; color: #666;">*Total bayar akan dihitung otomatis.</small>
            </div>

            <div class="form-group">
                <label for="status_reservasi">Status</label>
                <select name="status_reservasi" id="status_reservasi" class="form-control">
                    <option value="Booked">Booked (Booking Awal)</option>
                    <option value="Selesai">Selesai (Sudah Main)</option>
                    <option value="Batal">Batal</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Simpan Reservasi</button>
                <a href="{{ route('reservasi.index') }}" class="btn" style="background-color: #ccc;">Batal</a>
            </div>
        </form>
    </div>
@endsection
