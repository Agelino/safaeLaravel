@extends('layouts.layoutsAdmin')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Kelola Riwayat Baca</h2>
        <a href="{{ route('kelolariwayat.create') }}" class="btn btn-primary">
            + Tambah Riwayat
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <table class="table table-hover align-middle">
                <thead class1="table-light">
                    <tr>
                        <th>User</th>
                        <th>Judul Buku</th>
                        <th>Progress</th>
                        <th>Terakhir Baca</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($histories as $history)
                        <tr>
                            <td>
                                {{ $history->user->username 
                                    ?? ($history->user->nama_depan . ' ' . $history->user->nama_belakang) 
                                    ?? '-' }}
                            </td>

                            <td>{{ $history->book->title ?? '-' }}</td>

                            <td>{{ $history->progress }}%</td>

                            <td>{{ $history->last_read_at }}</td>

                            <td>
                                <a href="{{ route('kelolariwayat.edit', $history->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('kelolariwayat.delete', $history->id) }}" 
                                      method="POST" 
                                      style="display:inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Belum ada riwayat baca.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
