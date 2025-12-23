@extends('layouts.app')

@section('title', 'Pembayaran - Safae')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(180deg, #f0f6ff, #ffffff);
    }
    .glass-card {
        background: rgba(13, 110, 253, 0.75);
        backdrop-filter: blur(12px);
        border-radius: 16px;
        color: #fff;
    }
    .package-card {
        cursor: pointer;
        transition: 0.3s;
    }
    .package-card:hover {
        transform: translateY(-5px);
    }
    .package-card.active {
        border: 2px solid #0d6efd;
        background-color: #eef4ff;
    }
</style>

<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- SALDO POIN -->
    <div class="glass-card shadow p-4 mb-4">
        <small class="opacity-75">Saldo Poin Kamu</small>
        <h2 class="fw-bold mb-0">🪙 {{ $saldoPoin }} Poin</h2>
        <small class="opacity-75">
            Gunakan poin untuk membuka buku premium
        </small>
    </div>

    <h3 class="fw-bold mb-1">Pembayaran Safae</h3>
    <p class="text-muted mb-4">
        Beli poin untuk mengakses buku premium
    </p>

    <form method="POST" action="{{ route('pembayaran.proses') }}">
        @csrf

        <input type="hidden" name="points" id="inputPoints" value="50">
        <input type="hidden" name="price" id="inputPrice" value="5000">

        <div class="row">
            <!-- PAKET -->
            <div class="col-md-8">
                <h5 class="fw-semibold mb-3">Pilih Paket Poin</h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card package-card text-center p-3"
                             onclick="selectPackage(this, 30, 3000)">
                            <h5>30 Poin</h5>
                            <p class="fw-bold text-primary">Rp 3.000</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card package-card text-center p-3 active"
                             onclick="selectPackage(this, 50, 5000)">
                            <span class="badge bg-success mb-2">Populer</span>
                            <h5>50 Poin</h5>
                            <p class="fw-bold text-primary">Rp 5.000</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card package-card text-center p-3"
                             onclick="selectPackage(this, 100, 9000)">
                            <span class="badge bg-warning text-dark mb-2">Best Value</span>
                            <h5>100 Poin</h5>
                            <p class="fw-bold text-primary">Rp 9.000</p>
                        </div>
                    </div>
                </div>

                <!-- METODE -->
                <h5 class="fw-semibold mt-4 mb-3">Metode Pembayaran</h5>
                <div class="card p-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode" value="qris" checked>
                        <label class="form-check-label">QRIS</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode" value="ovo">
                        <label class="form-check-label">OVO</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode" value="dana">
                        <label class="form-check-label">DANA</label>
                    </div>
                </div>
            </div>

            <!-- RINGKASAN -->
            <div class="col-md-4">
    <div class="sticky-wrapper">
        <div class="card p-4 shadow-sm ringkasan-card">
            <h5 class="fw-semibold mb-3">Ringkasan</h5>

            <div class="d-flex justify-content-between">
                <span>Paket</span>
                <span id="summaryPoints">50 Poin</span>
            </div>

            <div class="d-flex justify-content-between mt-2">
                <span>Total</span>
                <span class="fw-bold" id="summaryTotal">Rp 5.000</span>
            </div>

            <button class="btn btn-primary w-100 mt-3">
                Bayar Sekarang
            </button>

            <small class="text-muted d-block mt-3 text-center">
                🔒 Pembayaran aman & poin otomatis masuk
            </small>
        </div>
    </div>
</div>


<script>
function selectPackage(el, points, price) {
    document.querySelectorAll('.package-card').forEach(card => {
        card.classList.remove('active');
    });

    el.classList.add('active');

    document.getElementById('summaryPoints').innerText = points + ' Poin';
    document.getElementById('summaryTotal').innerText =
        'Rp ' + price.toLocaleString('id-ID');

    document.getElementById('inputPoints').value = points;
    document.getElementById('inputPrice').value = price;
}
</script>
@endsection
