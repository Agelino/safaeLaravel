@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Forum')

@section('content')

<div class="container mt-4">
    <h2 class="fw-bold mb-3">Kelola Forum</h2>

    <div class="card p-4 shadow-sm">

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Judul Topik</th>
                    <th>Pembuat</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($topics as $topic)
                <tr>
                    <td>{{ $topic->judul }}</td>
                    <td>{{ $topic->user->username ?? $topic->user->name ?? 'User' }}</td>
                    <td>{{ $topic->created_at->format('d/m/Y') }}</td>

                    <td>
                        <a href="{{ route('admin.forum.detail', $topic->id) }}"
                           class="btn btn-info btn-sm">
                           Detail
                        </a>

                        <a href="{{ route('admin.forum.topik.hapus', $topic->id) }}"
                           onclick="return confirm('Hapus topik ini?')"
                           class="btn btn-danger btn-sm">
                           Hapus
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection
