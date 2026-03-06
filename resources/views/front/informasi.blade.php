@extends('layouts.main')

@section('title', $judulHalaman)

@section('content')

<section class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">{{ $judulHalaman }}</h2>
                <p class="section-subtitle mb-0">{{ $subjudul }}</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($artikel as $item)
                <div class="col-md-4">
                    <div class="card card-soft h-100">
                        <img
                            src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/600x220?text=Artikel' }}"
                            alt="{{ $item->judul }}"
                            class="card-img-top">
                        <div class="card-body d-flex flex-column">
                            <small class="text-uppercase text-muted mb-1">
                                {{ ucfirst($item->kategori) }}
                            </small>
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($item->deskripsi_berita, 120) }}
                            </p>
                            <a href="{{ route('informasi.detail', $item->id) }}"
                               class="stretched-link text-primary small">
                                Baca selengkapnya
                            </a>
                        </div>
                        <div class="card-footer small text-muted">
                            Dipublikasikan: {{ $item->created_at?->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    Belum ada artikel.
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $artikel->links() }}
        </div>

    </div>
</section>

@endsection
