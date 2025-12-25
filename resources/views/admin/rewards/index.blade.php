@extends('layouts.layoutsAdmin')

@section('title', 'Kelola Reward')

@section('content')
<div class="container">
    <h2 class="mb-4">Kelola Reward User</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Poin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td><strong>{{ $user->points }}</strong></td>
                <td>
                    {{-- TAMBAH POINT --}}
                    <form action="{{ route('admin.reward.add', $user) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="number" name="points" class="form-control form-control-sm d-inline w-50" required>
                        <button class="btn btn-success btn-sm mt-1">Tambah</button>
                    </form>

                    {{-- KURANGI POINT --}}
                    <form action="{{ route('admin.reward.remove', $user) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="number" name="points" class="form-control form-control-sm d-inline w-50" required>
                        <button class="btn btn-danger btn-sm mt-1">Kurangi</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
