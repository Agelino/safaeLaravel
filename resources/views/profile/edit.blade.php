@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<style>
    .edit-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .edit-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .edit-avatar {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .edit-avatar img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f1f3f5;
    }

    .form-label {
        font-weight: 600;
        font-size: 14px;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 14px;
    }

    .btn-rounded {
        border-radius: 30px;
        padding: 10px 22px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .edit-avatar {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="edit-wrapper">

    <div class="edit-card">

        {{-- HEADER --}}
        <div class="mb-4">
            <h4 class="fw-bold mb-1">Edit Profil</h4>
            <p class="text-muted mb-0">
                Perbarui informasi akun Safae kamu
            </p>
        </div>

        {{-- AVATAR --}}
        <div class="edit-avatar">
            <img src="{{ $profile->foto_profil
                ? asset($profile->foto_profil)
                : 'https://ui-avatars.com/api/?name='.$profile->username.'&background=0d6efd&color=fff' }}"
                 alt="Foto Profil">

            <div>
                <p class="fw-semibold mb-1">{{ $profile->username }}</p>
                <small class="text-muted">
                    Ukuran disarankan 1:1 (jpg, png)
                </small>
            </div>
        </div>

        {{-- FORM --}}
        <form method="POST"
              enctype="multipart/form-data"
              action="{{ url('/profile/update') }}">
            @csrf

            <div class="row">

                {{-- USERNAME --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text"
                           name="username"
                           class="form-control"
                           value="{{ $profile->username }}"
                           required>
                </div>

                {{-- SOCIAL MEDIA --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Social Media</label>
                    <input type="text"
                           name="social_media"
                           class="form-control"
                           placeholder="Instagram / Twitter / LinkedIn"
                           value="{{ $profile->social_media }}">
                </div>

                {{-- BIO --}}
                <div class="col-12 mb-3">
                    <label class="form-label">Bio</label>
                    <textarea name="bio"
                              rows="4"
                              class="form-control"
                              placeholder="Ceritakan sedikit tentang dirimu">{{ $profile->bio }}</textarea>
                </div>

                {{-- FOTO --}}
                <div class="col-12 mb-4">
                    <label class="form-label">Foto Profil Baru</label>
                    <input type="file"
                           name="foto_profil"
                           class="form-control">
                </div>
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <a href="{{ url('/profile') }}"
                    class="btn btn-secondary btn-rounded">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>

                <button type="submit"
                        class="btn btn-primary btn-rounded">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
