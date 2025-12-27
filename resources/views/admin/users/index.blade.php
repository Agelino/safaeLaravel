@extends('layouts.layoutsAdmin')

@section('title', 'Kelola User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-4">

    <div class="container-fluid" style="max-width: 1300px;">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Kelola User</h2>
                <p class="text-muted mb-0">
                    Manajemen akun pengguna dalam sistem
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="btn btn-primary d-flex align-items-center gap-2 shadow-sm rounded-pill px-4">
                <i class="fas fa-user-plus"></i>
                Tambah User
            </a>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success rounded-4 shadow-sm">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- CARD --}}
        <div class="card border-0 shadow-lg rounded-4">

            {{-- CARD HEADER --}}
            <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-semibold mb-0">Daftar Pengguna</h6>

                    {{-- SEARCH (UI ONLY) --}}
                    <div class="input-group" style="max-width: 280px;">
                        <span class="input-group-text bg-light border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                               class="form-control border-0 bg-light"
                               placeholder="Cari user...">
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive px-4 pb-4">
                <table class="table align-middle mb-0">
                    <thead class="text-muted small border-bottom">
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-bottom">

                            {{-- USER INFO --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($user->foto_profil)
                                        <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                             class="rounded-circle border"
                                             style="width:48px;height:48px;object-fit:cover;">
                                    @else
                                        <div class="rounded-circle bg-primary bg-opacity-10
                                                    d-flex align-items-center justify-content-center"
                                             style="width:48px;height:48px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">{{ $user->username }}</div>
                                        <small class="text-muted">ID #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- EMAIL --}}
                            <td class="text-muted">
                                {{ $user->email }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                    Aktif
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle"
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.users.show', $user->id) }}">
                                                <i class="fas fa-eye me-2 text-info"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.users.edit', $user->id) }}">
                                                <i class="fas fa-edit me-2 text-warning"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash fa-3x mb-3"></i>
                                <div>Belum ada data pengguna</div>
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
