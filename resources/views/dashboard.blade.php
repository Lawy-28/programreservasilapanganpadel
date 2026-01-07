@extends('layout')

@section('content')
<div class="row mb-4">
    <!-- Card 1: Total Booking (Biru) -->
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Booking Hari Ini</h6>
                        <h2 class="mt-2 fw-bold">{{ $totalBookingHariIni }}</h2>
                    </div>
                    <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Lapangan Terpakai (Hijau) -->
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Lapangan Terpakai</h6>
                        <h2 class="mt-2 fw-bold">{{ $lapanganTerpakai }} <span class="fs-6 fw-normal">/ {{ $totalLapangan }}</span></h2>
                    </div>
                    <i class="bi bi-grid-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Pendapatan (Kuning/Dark) -->
    <div class="col-md-4">
        <div class="card text-dark bg-warning mb-3 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Pendapatan Hari Ini</h6>
                        <h2 class="mt-2 fw-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h2>
                    </div>
                    <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card 4: Reservasi Terbaru -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">Reservasi Terbaru</h5>
        <a href="{{ route('reservasi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
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
                @forelse($reservasiTerbaru as $res)
                <tr>
                    <td class="ps-4 fw-medium">{{ $res->pelanggan->nama }}</td>
                    <td>{{ $res->lapangan->nama }}</td>
                    <td>{{ $res->tanggal }}</td>
                    <td>{{ $res->jam_mulai }} - {{ $res->jam_selesai }}</td>
                    <td>
                        <span class="badge rounded-pill 
                            {{ $res->status_reservasi == 'Lunas' ? 'bg-success' : ($res->status_reservasi == 'Batal' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ $res->status_reservasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada reservasi terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
