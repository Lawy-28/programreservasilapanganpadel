@extends('layout')

@section('content')

    <div class="card">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0 fw-bold">Jadwal Lapangan</h5>
                <small class="text-muted">Cek ketersediaan lapangan pada tanggal tertentu</small>
            </div>
            <div>
                <form action="{{ route('jadwal.index') }}" method="GET" class="d-flex align-items-center">
                    <label for="date" class="me-2 fw-medium">Tanggal:</label>
                    <input type="date" name="date" id="date" class="form-control form-control-sm" 
                           value="{{ $date }}" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        <div class="card-body">
            @forelse ($lapangan as $l)
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded p-2 me-3">
                            <i class="bi bi-grid-3x3-gap-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $l->nama_lapangan }}</h6>
                            <small class="text-muted">{{ $l->kategori }}</small>
                        </div>
                    </div>

                    @php
                        $bookings = $reservasi->where('id_lapangan', $l->id_lapangan);
                    @endphp

                    <div class="row g-3">
                        @if ($bookings->isEmpty())
                            <div class="col-12">
                                <div class="alert alert-light border text-center text-muted mb-0">
                                    <i class="bi bi-calendar-check me-2"></i> Lapangan tersedia seharian (Belum ada booking).
                                </div>
                            </div>
                        @else
                            @foreach ($bookings as $r)
                                <div class="col-md-3 col-sm-6">
                                    <div class="card h-100 border-0 shadow-sm {{ $r->status_reservasi == 'Selesai' ? 'bg-success bg-opacity-10' : 'bg-primary bg-opacity-10' }}">
                                        <div class="card-body p-3 text-center">
                                            <h6 class="fw-bold mb-1">
                                                {{ \Carbon\Carbon::parse($r->jam_mulai)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($r->jam_selesai)->format('H:i') }}
                                            </h6>
                                            @if($r->status_reservasi == 'Member')
                                                <span class="badge bg-warning text-dark">Member</span>
                                            @elseif($r->status_reservasi == 'Selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-primary">Booked</span>
                                            @endif
                                            
                                            <!-- Opsional: Tampilkan nama jika login sebagai admin/staff -->
                                            <div class="mt-2 small text-muted text-truncate">
                                                {{ $r->pelanggan->nama ?? 'Pelanggan' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @if(!$loop->last)
                    <hr class="my-4 text-muted opacity-25">
                @endif
            @empty
                <div class="text-center py-5">
                    <p class="text-muted">Tidak ada data lapangan.</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection
