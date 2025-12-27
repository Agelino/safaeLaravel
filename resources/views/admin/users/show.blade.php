@extends('layouts.layoutsAdmin')

@section('title', 'Detail User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-4">

    <div class="container" style="max-width: 900px;">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Detail User</h2>
                <p class="text-muted mb-0">
                    Informasi lengkap akun pengguna
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="btn btn-light rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- PROFILE CARD --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- TOP PROFILE --}}
            <div class="bg-primary bg-opacity-10 text-center pt-5 pb-4">
                @if($user->foto_profil)
                    <img src="{{ asset('storage/' . $user->foto_profil) }}"
                         alt="Foto Profil"
                         class="rounded-circle border border-4 border-white shadow"
                         style="width:140px;height:140px;object-fit:cover;">
                @else
                    <div class="rounded-circle bg-white shadow
                                d-flex align-items-center justify-content-center mx-auto"
                         style="width:140px;height:140px;">
                        <i class="fas fa-user fa-3x text-primary"></i>
                    </div>
                @endif

                <h4 class="fw-bold mt-3 mb-1">{{ $user->username }}</h4>
                <p class="text-muted mb-0">{{ $user->email }}</p>
            </div>

            {{-- DETAIL INFO --}}
            <div class="card-body px-5 py-4">

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="info-box p-4 rounded-4 bg-light h-100">
                            <small class="text-muted">User ID</small>
                            <h6 class="fw-semibold mb-0">#{{ $user->id }}</h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box p-4 rounded-4 bg-light h-100">
                            <small class="text-muted">Status Akun</small><br>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 mt-1">
                                Aktif
                            </span>
                        </div>
                    </div>

                </div>

            </div>

            {{-- FOOTER ACTION --}}
            <div class="card-footer bg-white border-0 px-5 pb-4">
                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.users.edit', $user->id) }}"
                       class="btn btn-warning rounded-pill px-4">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>

                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger rounded-pill px-4">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </div>

</main>
@endsection
