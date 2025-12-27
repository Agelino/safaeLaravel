@extends('layouts.layoutsAdmin')

@section('title', 'Edit User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-4">

    <div class="container" style="max-width: 900px;">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Edit User</h2>
                <p class="text-muted mb-0">
                    Perbarui informasi akun pengguna
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="btn btn-light rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="alert alert-danger rounded-4 shadow-sm">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CARD --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- PROFILE HEADER --}}
            <div class="bg-primary bg-opacity-10 text-center pt-5 pb-4">
                @if ($user->foto_profil)
                    <img src="{{ asset('storage/' . $user->foto_profil) }}"
                         class="rounded-circle border border-4 border-white shadow mb-3"
                         style="width:140px;height:140px;object-fit:cover;">
                @else
                    <div class="rounded-circle bg-white shadow
                                d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:140px;height:140px;">
                        <i class="fas fa-user fa-3x text-primary"></i>
                    </div>
                @endif

                <h5 class="fw-bold mb-0">{{ $user->username }}</h5>
                <small class="text-muted">{{ $user->email }}</small>
            </div>

            {{-- FORM --}}
            <div class="card-body px-5 py-4">
                <form action="{{ route('admin.users.update', $user->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

                        {{-- USERNAME --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text"
                                   name="username"
                                   class="form-control form-control-lg @error('username') is-invalid @enderror"
                                   value="{{ old('username', $user->username) }}"
                                   required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- EMAIL (READ ONLY) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email"
                                   class="form-control form-control-lg"
                                   value="{{ $user->email }}"
                                   disabled>
                        </div>

                        {{-- ROLE --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role"
                                    class="form-select form-select-lg @error('role') is-invalid @enderror"
                                    required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                    User
                                </option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- FOTO PROFIL --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <input type="file"
                                   name="foto_profil"
                                   class="form-control form-control-lg @error('foto_profil') is-invalid @enderror"
                                   accept="image/*">
                            <small class="text-muted">
                                Format JPG / PNG, maksimal 2MB
                            </small>
                            @error('foto_profil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-light rounded-pill px-4">
                            Batal
                        </a>
                        <button class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>

</main>
@endsection
