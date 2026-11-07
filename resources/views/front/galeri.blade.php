@extends('layouts.main')
@section('title', 'Galeri')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="section-title">Galeri Sekolah</h1>
            <p class="section-subtitle">Dokumentasi kegiatan dan fasilitas SMP Sains Al-Qur'an Klakah</p>
        </div>

        {{-- FOTO --}}
        @if($foto->count())
        <h4 class="fw-bold mb-3"><i class="bi bi-camera me-2"></i>Foto</h4>
        <div class="row g-3 mb-5">
            @foreach($foto as $item)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="galeri-thumb rounded overflow-hidden shadow-sm position-relative">
                    <img src="{{ image_url($item->file) }}" alt="{{ $item->judul }}" class="w-100" style="height:200px;object-fit:cover;">
                    <div class="galeri-overlay">
                        <h6 class="text-white mb-0 small px-2 text-center">{{ $item->judul }}</h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mb-4">
            {{ $foto->links() }}
        </div>
        @endif

        {{-- VIDEO --}}
        @if($video->count())
        <h4 class="fw-bold mb-3"><i class="bi bi-play-circle me-2"></i>Video</h4>
        <div class="row g-3">
            @foreach($video as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card card-soft h-100">
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ $item->url_video }}" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ $item->judul }}</h6>
                        @if($item->deskripsi)
                            <p class="small text-muted mb-0">{{ Str::limit($item->deskripsi, 100) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(!$foto->count() && !$video->count())
        <div class="text-center py-5">
            <i class="bi bi-images fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada galeri yang ditampilkan.</p>
        </div>
        @endif
    </div>
</section>
@endsection
