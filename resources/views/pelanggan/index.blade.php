@extends('layout')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Data Pelanggan</h2>
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
        </div>

        @if ($pelanggan->isEmpty())
            <p style="text-align: center; color: #777;">Belum ada data pelanggan.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->no_hp }}</td>
                            <td>{{ $p->email ?? '-' }}</td>
                            <td>
                                @if($p->status == 'aktif')
                                    <span style="color: green; font-weight: bold;">Aktif</span>
                                @else
                                    <span style="color: red; font-weight: bold;">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" class="btn btn-primary"
                                    style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Edit</a>

                                <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection