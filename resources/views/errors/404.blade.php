@extends('layouts.main')

@section('title', '404 — Halaman Tidak Ditemukan')

@section('content')
<div class="container py-5 my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div style="font-size: 5rem; font-weight: 800; color: #5f6fff; line-height: 1;">404</div>
            <h1 class="h3 fw-bold mt-3 mb-2 text-dark">Halaman Tidak Ditemukan</h1>
            <p class="text-muted mb-4">
                Maaf, halaman yang Anda tuju tidak ditemukan atau mungkin telah dipindahkan.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                <i class="bi bi-house-door-fill me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

