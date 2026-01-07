@extends('layout')

@section('content')

    <div class="card">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0 fw-bold">Data Lapangan</h5>
                <small class="text-muted">Kelola data lapangan padel</small>
            </div>
            <div>
                <a href="{{ route('lapangan.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Lapangan
                </a>
            </div>
        </div>

    <div class="card-body p-0">
        @if ($lapangan->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-people fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted">Belum ada data lapangan.</p>
            </div>
        @else
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Lapangan</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lapangan as $lapangan)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td class="fw-medium">{{ $lapangan->nama_lapangan }}</td>
                            <td>{{ $lapangan->kategori }}</td>
                            <td>Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</td>
                            <td>{{ $lapangan->status_lapangan }}</td>
                            <td class="text-end pe-4">
                            <!-- Tombol Edit -->
                            <a href="{{ route('lapangan.edit', $lapangan->id_lapangan) }}" 
                               class="btn btn-sm btn-outline-primary me-1" 
                               title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('lapangan.destroy', $lapangan->id_lapangan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')" 
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection