@extends('layouts.main')

@section('title', $item->judul ?? 'Ekstrakurikuler')

@section('content')
<div class="container py-5">

    {{-- Breadcrumb + Back --}}
    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('landing') }}">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('landing') }}#section-ekskul">Ekstrakurikuler</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item->judul }}
                </li>
            </ol>
        </nav>

        <a href="{{ route('landing') }}#section-ekskul" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar ekskul
        </a>
    </div>

    {{-- Card utama --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="row g-0 flex-column flex-md-row">
                    {{-- Gambar --}}
                    <div class="col-md-5">
                        <div class="ratio ratio-4x3">
                            <img
                                src="{{ $item->gambar ? asset('storage/'.$item->gambar)
                                                       : 'https://via.placeholder.com/800x600?text=Ekstrakurikuler' }}"
                                alt="{{ $item->judul }}"
                                class="w-100 h-100 object-fit-cover"
                            >
                        </div>
                    </div>

                    {{-- Teks --}}
                    <div class="col-md-7">
                        <div class="p-4 p-md-5">
                            <h1 class="h3 fw-bold mb-3">
                                {{ $item->judul }}
                            </h1>

                            <p class="text-muted mb-0 lh-lg">
                                {!! nl2br(e($item->deskripsi)) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
