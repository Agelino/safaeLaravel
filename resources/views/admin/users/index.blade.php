@extends('layouts.layoutsAdmin')

@section('title', 'Kelola User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-4">

    <div class="container" style="max-width: 1000px;">

        <h2 class="mb-4 text-center">Daftar User</h2>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="card shadow-sm mx-auto">
            <div class="card-body p-0">
                <table class="table table-bordered table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th style="width: 90px;">Foto</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th style="width: 280px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>

                            {{-- FOTO PROFIL --}}
                            <td>
                                @if($user->profile_image)
                                    <img
                                        src="{{ asset('storage/' . $user->profile_image) }}"
                                        alt="Foto Profil"
                                        class="rounded-circle"
                                        style="width: 45px; height: 45px; object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                       class="btn btn-info btn-sm text-white">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="btn btn-warning btn-sm text-white">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</main>
@endsection
