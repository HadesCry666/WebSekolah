@extends('layouts.main')

@section('title', 'Informasi')

@section('content')
<section class="py-5">
    <div class="container">

        <div class="mb-3">
            <a href="{{ route('informasi.index') }}" class="text-muted small">
                <i class="bi bi-arrow-left"></i> Kembali ke daftar informasi
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <span class="badge
                    {{ $item->kategori === 'berita' ? 'bg-primary' : 'bg-success' }} mb-2">
                    {{ strtoupper($item->kategori) }}
                </span>

                <h1 class="mb-2 fw-bold">{{ $item->judul }}</h1>

                <p class="text-muted small mb-3">
                    Dipublikasikan: {{ $item->created_at?->format('d M Y') }}
                </p>

                @if($item->gambar)
                    <div class="mb-4">
                        <img src="{{ asset('storage/'.$item->gambar) }}"
                             class="img-fluid rounded-4 shadow-sm w-100">
                    </div>
                @endif

                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm">
                    {!! nl2br(e($item->deskripsi_berita)) !!}
                </div>

            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="bg-white rounded-4 shadow-sm p-3 p-md-4">
                    <h5 class="mb-3">Kategori</h5>
                    <p class="mb-1">
                        {{ $item->kategori === 'berita' ? 'Berita Sekolah' : 'Prestasi Siswa' }}
                    </p>
                    <p class="text-muted small mb-0">
                        Informasi resmi dari SMPN Sains Al-Qur'an Klakah.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
