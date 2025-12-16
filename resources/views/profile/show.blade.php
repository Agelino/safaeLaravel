<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ $profile['username'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-primary bg-gradient">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-4 text-center" style="max-width: 25rem;">
        <div class="card-body p-4">
            
            <div class="mb-3">
                <img src="{{ asset($profile['foto_profil']) }}" 
                    alt="Foto Profil" 
                    class="rounded-circle shadow-sm mx-auto d-block object-fit-cover"
                    style="width:130px; height:130px;">
            </div>

            <h4 class="fw-bold mb-2">{{ $profile['username'] }}</h4>

            <p class="mb-2 text-muted">
                <i class="bi bi-link-45deg"></i> <strong>Social Media:</strong><br>
                {{ $profile['social_media'] }}
            </p>

            <p class="mb-3 text-secondary">
                <i class="bi bi-person-lines-fill"></i> <strong>Bio:</strong><br>
                {{ $profile['bio'] }}
            </p>

            <div class="d-flex justify-content-center gap-2 mt-3">
                <a href="{{ url('/profile/edit/'.$profile['id']) }}" class="btn btn-primary rounded-pill px-3"> 
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="{{ url('/profile/delete/'.$profile['id']) }}" 
                   class="btn btn-danger rounded-pill px-3"
                   onclick="return confirm('Yakin ingin menghapus profil ini?')">
                    <i class="bi bi-trash"></i> Hapus
                </a>
                <a href="{{ url('/home') }}" class="btn btn-secondary rounded-pill px-3">
                    <i class="bi bi-house-door"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
