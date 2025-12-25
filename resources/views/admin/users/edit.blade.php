@extends('layouts.layoutsAdmin')

@section('title', 'Edit User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4">

    <div class="container py-4" style="max-width: 600px;">
        <h2 class="mb-4">Edit User</h2>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- FORM EDIT USER --}}
        <form action="{{ route('admin.users.update', $user->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            {{-- USERNAME --}}
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input
                    type="text"
                    name="username"
                    class="form-control"
                    value="{{ old('username', $user->username) }}"
                    required>
            </div>

            {{-- EMAIL (READ ONLY) --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    value="{{ $user->email }}"
                    disabled>
            </div>

            {{-- FOTO PROFIL --}}
            <div class="mb-3">
                <label class="form-label">Foto Profil</label><br>

                @if ($user->foto_profil)
                    <img
                        src="{{ asset('storage/' . $user->foto_profil) }}"
                        alt="Foto Profil"
                        class="rounded mb-2"
                        style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <p class="text-muted mb-2">Belum ada foto profil</p>
                @endif

                <input
                    type="file"
                    name="foto_profil"
                    class="form-control"
                    accept="image/*">
            </div>

            {{-- BUTTON --}}
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

</main>
@endsection
