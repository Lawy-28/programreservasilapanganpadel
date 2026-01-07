@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">Buat Reservasi Baru</h5>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('reservasi.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_pelanggan" class="form-label">Pelanggan</label>
                        <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id_pelanggan }}" {{ old('id_pelanggan') == $p->id_pelanggan ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->no_hp }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_lapangan" class="form-label">Lapangan</label>
                        <select name="id_lapangan" id="id_lapangan" class="form-select" required>
                            <option value="">-- Pilih Lapangan --</option>
                            @foreach($lapangan as $l)
                                <option value="{{ $l->id_lapangan }}" {{ old('id_lapangan') == $l->id_lapangan ? 'selected' : '' }}>
                                    {{ $l->nama_lapangan }} (Rp {{ number_format($l->harga_per_jam, 0, ',', '.') }}/jam) - Status: {{ $l->status_lapangan }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Pilih lapangan yang tersedia. Lapangan 'Perawatan' tidak bisa dipilih.</div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Main</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="status_reservasi" class="form-label">Status Awal</label>
                        <select name="status_reservasi" id="status_reservasi" class="form-select">
                            <option value="Booked" selected>Booked (Booking Awal)</option>
                            <option value="Selesai">Selesai (Langsung Main)</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('reservasi.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Reservasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
