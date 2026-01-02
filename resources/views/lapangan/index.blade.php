@extends('layout')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Data Lapangan</h2>
            <a href="{{ route('lapangan.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        @if ($lapangan->isEmpty())
            <p style="text-align: center; color: #777;">Belum ada data lapangan.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lapangan</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lapangan as $lapangan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lapangan->nama_lapangan }}</td>
                            <td>{{ $lapangan->kategori }}</td>
                            <td>Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</td>
                            <td>{{ $lapangan->status_lapangan }}</td>
                            <td>
                                <a href="{{ route('lapangan.edit', $lapangan->id_lapangan) }}" class="btn btn-primary"
                                    style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Edit</a>

                                <form action="{{ route('lapangan.destroy', $lapangan->id_lapangan) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection