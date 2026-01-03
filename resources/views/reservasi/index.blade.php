@extends('layout')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Data Reservasi</h2>
            <a href="{{ route('reservasi.create') }}" class="btn btn-primary">Buat Reservasi Baru</a>
        </div>

        @if ($reservasi->isEmpty())
            <p style="text-align: center; color: #777;">Belum ada data reservasi.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Lapangan</th>
                        <th>Waktu Main</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservasi as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $r->pelanggan->nama }}</strong><br>
                                <small style="color: #666;">{{ $r->pelanggan->no_hp }}</small>
                            </td>
                            <td>{{ $r->lapangan->nama_lapangan }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}<br>
                                <small>{{ \Carbon\Carbon::parse($r->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($r->jam_selesai)->format('H:i') }}</small>
                            </td>
                            <td>Rp {{ number_format($r->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($r->status_reservasi == 'Booked')
                                    <span style="color: blue; font-weight: bold;">Booked</span>
                                @elseif($r->status_reservasi == 'Selesai')
                                    <span style="color: green; font-weight: bold;">Selesai</span>
                                @else
                                    <span style="color: red; font-weight: bold;">Batal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('reservasi.edit', $r->id_reservasi) }}" class="btn btn-primary"
                                    style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Edit</a>

                                <form action="{{ route('reservasi.destroy', $r->id_reservasi) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;"
                                        onclick="return confirm('Batalkan reservasi ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
