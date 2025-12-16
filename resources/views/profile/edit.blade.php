<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil {{ $profile['username'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Edit Profil</h4>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="{{ url('/profile/update/'.$profile['id']) }}">
                @csrf

                <div class="mb-3 text-center">
                    <img src="{{ asset($profile['foto_profil']) }}" 
                         class="rounded-circle" width="120" height="120" 
                         style="object-fit:cover;" alt="Foto Profil">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text" name="username" class="form-control" value="{{ $profile['username'] }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Social Media</label>
                    <input type="text" name="social_media" class="form-control" value="{{ $profile['social_media'] }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" rows="3">{{ $profile['bio'] }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Profil Baru</label>
                    <input type="file" name="profile_pic" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('/profile/'.$profile['id']) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
