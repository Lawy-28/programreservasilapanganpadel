@extends('layout')

@section('content')
<div class="row mb-4">
    <!-- Kartu 1: Menampilkan Total Booking Hari Ini -->
    <!-- Background warna biru (bg-primary) -->
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Booking Hari Ini</h6>
                        <h2 class="mt-2 fw-bold">{{ $totalBookingHariIni }}</h2>
                    </div>
                    <!-- Ikon kalender -->
                    <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu 2: Menampilkan Jumlah Lapangan yang Terpakai -->
    <!-- Background warna hijau (bg-success) -->
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Lapangan Terpakai</h6>
                        <!-- Format: Terpakai / Total Lapangan -->
                        <h2 class="mt-2 fw-bold">{{ $lapanganTerpakai }} <span class="fs-6 fw-normal">/ {{ $totalLapangan }}</span></h2>
                    </div>
                    <!-- Ikon grid/lapangan -->
                    <i class="bi bi-grid-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu 3: Menampilkan Pendapatan Uang Hari Ini -->
    <!-- Background warna kuning (bg-warning) -->
    <div class="col-md-4">
        <div class="card text-dark bg-warning mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Pendapatan Hari Ini</h6>
                        <!-- Format Mata Uang Rupiah -->
                        <h2 class="mt-2 fw-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h2>
                    </div>
                    <!-- Ikon uang -->
                    <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kartu 4: Tabel Daftar Reservasi Terbaru -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-0 fw-bold">Jadwal Reservasi</h5>
            <small class="text-muted">Daftar booking pada tanggal {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</small>
        </div>
        <div class="d-flex align-items-center">
            <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center me-3">
                <label for="date" class="me-2 fw-medium text-nowrap">Pilih Tanggal:</label>
                <input type="date" name="date" id="date" class="form-control form-control-sm" 
                       value="{{ $date }}" onchange="this.form.submit()">
            </form>
            <a href="{{ route('reservasi.index') }}" class="btn btn-sm btn-outline-primary text-nowrap">Lihat Semua</a>
        </div>
    </div>
    
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Pelanggan</th>
                    <th>Lapangan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop data reservasi terbaru -->
                @forelse($reservasiTerbaru as $res)
                <tr>
                    <td class="ps-4 fw-medium">{{ $res->pelanggan->nama }}</td>
                    <td>{{ $res->lapangan->nama_lapangan }}</td>
                    <td>{{ $res->tanggal }}</td>
                    <td>{{ $res->jam_mulai }} - {{ $res->jam_selesai }}</td>
                    <td>
                        <!-- Badge status warna-warni -->
                        <span class="badge rounded-pill 
                            {{ $res->status_reservasi == 'Selesai' ? 'bg-success' : ($res->status_reservasi == 'Batal' ? 'bg-danger' : 'bg-primary') }}">
                            {{ $res->status_reservasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <!-- Jika tidak ada data -->
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada reservasi pada tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

