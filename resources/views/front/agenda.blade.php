@extends('layouts.main')
@section('title', 'Agenda & Kegiatan')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="section-title">Agenda & Kegiatan</h1>
            <p class="section-subtitle">Jadwal kegiatan SMP Sains Al-Qur'an Klakah</p>
        </div>

        @forelse($agenda as $item)
        <div class="card card-soft mb-3">
            <div class="card-body d-flex align-items-center gap-4">
                <div class="agenda-date-box text-center flex-shrink-0" style="min-width:70px;">
                    <div class="fw-bold fs-3 text-primary">{{ $item->tanggal_mulai->format('d') }}</div>
                    <div class="small text-muted">{{ $item->tanggal_mulai->translatedFormat('M Y') }}</div>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">{{ $item->judul }}</h5>
                    @if($item->lokasi)
                        <p class="mb-1 text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $item->lokasi }}</p>
                    @endif
                    @if($item->waktu_mulai)
                        <p class="mb-1 text-muted small"><i class="bi bi-clock me-1"></i>{{ $item->waktu_mulai }}</p>
                    @endif
                    @if($item->deskripsi)
                        <p class="mb-0 text-muted small">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada agenda yang ditampilkan.</p>
        </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $agenda->links() }}
        </div>
    </div>
</section>
@endsection
