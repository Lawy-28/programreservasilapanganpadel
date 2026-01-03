@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Edit Reservasi</h2>
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

        <form action="{{ route('reservasi.update', $reservasi->id_reservasi) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_pelanggan">Pelanggan</label>
                <select name="id_pelanggan" id="id_pelanggan" class="form-control" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->id_pelanggan }}" {{ $reservasi->id_pelanggan == $p->id_pelanggan ? 'selected' : '' }}>
                            {{ $p->nama }} ({{ $p->no_hp }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_lapangan">Lapangan</label>
                <select name="id_lapangan" id="id_lapangan" class="form-control" required>
                    <option value="">-- Pilih Lapangan --</option>
                    @foreach($lapangan as $l)
                        <option value="{{ $l->id_lapangan }}" {{ $reservasi->id_lapangan == $l->id_lapangan ? 'selected' : '' }}>
                            {{ $l->nama_lapangan }} (Rp {{ number_format($l->harga_per_jam, 0, ',', '.') }}/jam)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Main</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $reservasi->tanggal) }}" required>
            </div>

            <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai', Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i')) }}" required>
            </div>

            <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai', Carbon\Carbon::parse($reservasi->jam_selesai)->format('H:i')) }}" required>
            </div>

            <div class="form-group">
                <label for="status_reservasi">Status</label>
                <select name="status_reservasi" id="status_reservasi" class="form-control">
                    <option value="Booked" {{ $reservasi->status_reservasi == 'Booked' ? 'selected' : '' }}>Booked</option>
                    <option value="Selesai" {{ $reservasi->status_reservasi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ $reservasi->status_reservasi == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update Reservasi</button>
                <a href="{{ route('reservasi.index') }}" class="btn" style="background-color: #ccc;">Batal</a>
            </div>
        </form>
    </div>
@endsection
