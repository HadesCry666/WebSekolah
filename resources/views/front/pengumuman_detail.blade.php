@extends('layouts.main')
@section('title', $item->judul)

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>

                <h1 class="fw-bold mb-2">{{ $item->judul }}</h1>
                <p class="text-muted mb-4">
                    <i class="bi bi-calendar3 me-1"></i>{{ $item->tanggal_publikasi->format('d M Y') }}
                </p>

                <div class="card card-soft p-4">
                    {!! nl2br(e($item->isi)) !!}
                </div>

                @if($item->lampiran)
                <div class="mt-3">
                    <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank" class="btn btn-outline-primary btn-pill">
                        <i class="bi bi-paperclip me-1"></i>Unduh Lampiran
                    </a>
                </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-secondary btn-pill">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Pengumuman
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
