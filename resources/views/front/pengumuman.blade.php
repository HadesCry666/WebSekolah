@extends('layouts.main')
@section('title', 'Pengumuman')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="section-title">Pengumuman</h1>
            <p class="section-subtitle">Informasi dan pengumuman resmi SMP Sains Al-Qur'an Klakah</p>
        </div>

        @forelse($pengumuman as $item)
        <div class="card card-soft mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <a href="{{ route('pengumuman.detail', $item->id) }}" class="text-decoration-none text-dark">
                                {{ $item->judul }}
                            </a>
                        </h5>
                        <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $item->tanggal_publikasi->format('d M Y') }}</small>
                    </div>
                    @if($item->lampiran)
                    <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank" class="btn btn-theme-outline btn-sm btn-pill">
                        <i class="bi bi-paperclip me-1"></i>Lampiran
                    </a>
                    @endif
                </div>
                <p class="text-muted mt-2 mb-0">{{ Str::limit(strip_tags($item->isi), 200) }}</p>
                <a href="{{ route('pengumuman.detail', $item->id) }}" class="link-baca-selengkapnya small mt-2 d-inline-block fw-semibold">
                    <span>Baca selengkapnya</span>
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-megaphone fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada pengumuman.</p>
        </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $pengumuman->links() }}
        </div>
    </div>
</section>
@endsection
