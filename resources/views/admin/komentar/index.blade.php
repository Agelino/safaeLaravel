@extends('layouts.layoutsAdmin') 

@section('title', 'Kelola Komentar')

@section('content')
<div class="container mt-4">

    <h3>Kelola Komentar</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>User</th>
                <th>Komentar</th>
                <th>Judul Buku</th>
                <th>Halaman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($komentar as $k)
            <tr>
                <td>{{ $k->user->username ?? '-' }}</td>
                <td>{{ $k->komentar }}</td>
                <td>{{ $k->book->title ?? '-' }}</td>
                <td>{{ $k->page }}</td>
                <td>
                    <form action="{{ route('admin.komentar.hapus', $k->id) }}" method="POST"
                          onsubmit="return confirm('Hapus komentar ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada komentar</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $komentar->links() }}

</div>
@endsection
