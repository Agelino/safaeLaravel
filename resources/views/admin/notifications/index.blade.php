@extends('layouts.admin')

@section('content')
<h3>Kelola Notifikasi Admin</h3>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Pesan</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notifications as $notif)
        <tr>
            <td>{{ $notif->title }}</td>
            <td>{{ $notif->message }}</td>
            <td>{{ $notif->is_read ? 'Sudah dibaca' : 'Belum dibaca' }}</td>
            <td>{{ $notif->created_at->format('d M Y H:i') }}</td>
            <td>
                @if(!$notif->is_read)
                <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-success">Tandai Sudah Dibaca</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
