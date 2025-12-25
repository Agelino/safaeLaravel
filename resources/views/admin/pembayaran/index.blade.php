@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kelola Pembayaran</h4>
        <span class="text-muted">Riwayat transaksi pembelian poin</span>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Poin</th>
                            <th>Harga</th>
                            <th>Metode</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayarans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-semibold">
                                    {{ $item->user_id }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    +{{ $item->points }} poin
                                </span>
                            </td>
                            <td class="fw-semibold">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ ucfirst($item->metode) }}
                                </span>
                            </td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data pembayaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
