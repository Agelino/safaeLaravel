@extends('layouts.layoutsAdmin') 

@section('title', 'Kelola Buku Favorit')

@section('content')
<div class="container">
    <h3 class="mb-4">📚 Kelola Buku Favorit User</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($favorites as $fav)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $fav->user->username }}</td>
                    <td>{{ $fav->book->title }}</td>
                    <td>{{ $fav->book->author }}</td>
                    <td>
                        <a href="{{ route('admin.favorit.show', $fav->id) }}"
                           class="btn btn-info btn-sm">
                            👁 Detail
                        </a>

                        <form action="{{ route('admin.favorit.destroy', $fav->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Hapus favorit ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                ❌ Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada buku favorit user
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
