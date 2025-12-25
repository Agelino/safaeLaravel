@extends('layouts.layoutsAdmin')

@section('title', 'Kelola User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-2">

    <div class="container" style="max-width: 1100px;">

        {{-- HEADER --}}
        <div class="mb-3">
            <h3 class="fw-bold mb-1">Kelola User</h3>
            <small class="text-muted">
                Daftar seluruh pengguna yang terdaftar di sistem
            </small>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- CARD TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">
                📋 Daftar User
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 90px;">Foto</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th style="width: 260px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="fw-semibold">{{ $user->id }}</td>

                            {{-- FOTO PROFIL --}}
                            <td>
                                @if($user->foto_profil)
                                    <img
                                        src="{{ asset($user->foto_profil) }}"
                                        alt="Foto Profil"
                                        class="rounded-circle border"
                                        style="width: 45px; height: 45px; object-fit: cover;">
                                @else
                                    <div
                                        class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 45px; height: 45px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="fw-semibold">{{ $user->username }}</td>
                            <td class="text-muted">{{ $user->email }}</td>

                            {{-- AKSI --}}
                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                       class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-muted py-4">
                                Tidak ada data user
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</main>
@endsection
