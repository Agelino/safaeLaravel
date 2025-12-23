@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Kelola Reward User</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>Total Poin</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->nama_depan }} {{ $user->nama_belakang }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    ⭐ {{ $user->points }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.reward.reset', $user) }}"
                                      method="POST"
                                      onsubmit="return confirm('Reset poin user ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        Reset Poin
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
