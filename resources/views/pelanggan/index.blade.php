@extends('layout')

@section('content')

    <div class="card">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0 fw-bold">Data Pelanggan</h5>
                <small class="text-muted">Kelola data pelanggan lapangan padel</small>
            </div>
            <div>
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan
                </a>
            </div>
        </div>

    <div class="card-body p-0">
        @if ($pelanggan->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-people fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted">Belum ada data pelanggan.</p>
            </div>
        @else
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Pelanggan</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($pelanggan as $p)
                    <tr>
                        <td class="ps-4">{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $p->nama }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td class="text-muted">{{ $p->email ?? '-' }}</td>
                        <td>
                            @if($p->status == 'aktif')
                                <span class="badge rounded-pill bg-success">Aktif</span>
                            @else
                                <span class="badge rounded-pill bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <!-- Tombol Edit -->
                            <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" 
                               class="btn btn-sm btn-outline-primary me-1" 
                               title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" class="d-inline">
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