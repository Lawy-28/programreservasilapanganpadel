@extends('layout')

@section('content')

    <div class="card">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0 fw-bold">Data Reservasi</h5>
                <small class="text-muted">Kelola jadwal dan pembayaran reservasi</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('reservasi.index') }}" method="GET" class="d-flex align-items-center">
                    <label for="date" class="me-2 fw-medium">Tanggal:</label>
                    <input type="date" name="date" id="date" class="form-control form-control-sm" 
                           value="{{ $date }}" onchange="this.form.submit()">
                </form>
                <a href="{{ route('reservasi.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Buat Reservasi
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($reservasi->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted">Belum ada data reservasi.</p>
                </div>
            @else
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Pelanggan</th>
                            <th>Lapangan</th>
                            <th>Waktu Main</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservasi as $r)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-medium">{{ $r->pelanggan->nama }}</div>
                                    <small class="text-muted">{{ $r->pelanggan->no_hp }}</small>
                                </td>
                                <td>{{ $r->lapangan->nama_lapangan }}</td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($r->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($r->jam_selesai)->format('H:i') }}
                                    </small>
                                </td>
                                <td class="fw-medium">Rp {{ number_format($r->total_bayar, 0, ',', '.') }}</td>
                                <td>
                                    @if($r->status_reservasi == 'Booked')
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Booked</span>
                                    @elseif($r->status_reservasi == 'Selesai')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Selesai</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Batal</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('reservasi.edit', $r->id_reservasi) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('reservasi.destroy', $r->id_reservasi) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection