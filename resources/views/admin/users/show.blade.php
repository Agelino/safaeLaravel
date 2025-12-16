@extends('layouts.layoutsAdmin')

@section('title', 'Detail User')

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4">

    <div class="container py-4">
        <h2>Detail User</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">
            Kembali
        </a>
    </div>

</main>
@endsection
