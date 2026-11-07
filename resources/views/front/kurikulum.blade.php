@extends('layouts.main')
@section('title', 'Kurikulum & Pembelajaran')

@section('content')
{{-- HERO KURIKULUM --}}
<section class="py-5 bg-light border-bottom">
    <div class="container text-center py-4">
        <span class="badge px-3 py-2 rounded-pill fw-semibold mb-3" style="background: rgba(13, 92, 58, 0.1); color: #0d5c3a; border: 1px solid rgba(13, 92, 58, 0.2);">
            <i class="bi {{ $pengantar->ikon ?? 'bi-book-half' }} me-1"></i> {{ $pengantar->poin_poin ?? 'Sistem Pendidikan Terpadu' }}
        </span>
        <h1 class="display-5 fw-bold text-navy mb-3">{{ $pengantar->judul ?? 'Kurikulum & Pembelajaran' }}</h1>
        <p class="lead text-secondary mx-auto mb-0" style="max-width: 760px;">
            {{ $pengantar->deskripsi ?? "SMP Sains Al-Qur'an Klakah menerapkan kurikulum terintegrasi yang mengharmoniskan standar Kurikulum Merdeka dengan pendalaman Sains Modern Berbasis Riset serta keagungan Tahfidz Al-Qur'an." }}
        </p>
    </div>
</section>

{{-- 3 PILAR KURIKULUM --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">3 Pilar Kurikulum Terintegrasi</h2>
            <p class="section-subtitle">Fondasi holistik dalam membentuk generasi cerdas intelektual dan mulia spiritual</p>
        </div>

        <div class="row g-4">
            @forelse($pilars as $index => $pilar)
                <div class="col-lg-4">
                    <div class="card card-soft h-100 p-4 p-md-5" style="border-top: 4px solid #0d5c3a !important;">
                        <div class="icon-circle bg-navy-soft mb-4">
                            <i class="bi {{ $pilar->ikon ?: 'bi-mortarboard-fill' }} fs-3 text-navy"></i>
                        </div>
                        <h3 class="h4 fw-bold text-navy mb-3">{{ $pilar->judul }}</h3>
                        <p class="text-secondary mb-4">
                            {{ $pilar->deskripsi }}
                        </p>
                        @if(count($pilar->poin_list) > 0)
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-secondary small">
                            @foreach($pilar->poin_list as $point)
                            <li class="d-flex align-items-center gap-2">
                                <i class="bi bi-check2 fw-bold" style="color: #0d5c3a;"></i> {{ $point }}
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">Data pilar kurikulum sedang disiapkan.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- STRUKTUR PEMBELAJARAN (TABS) --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Struktur Mata Pelajaran</h2>
            <p class="section-subtitle">Komposisi bidang studi yang dirancang berimbang untuk perkembangan siswa</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <ul class="nav nav-pills justify-content-center mb-4 gap-2" id="curriculumTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-2 rounded-pill fw-semibold" id="umum-tab" data-bs-toggle="pill" data-bs-target="#tab-umum" type="button" role="tab">
                            <i class="bi bi-journal-text me-1"></i> Muatan Nasional (Umum)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-2 rounded-pill fw-semibold" id="islam-tab" data-bs-toggle="pill" data-bs-target="#tab-islam" type="button" role="tab">
                            <i class="bi bi-moon-stars me-1"></i> Keislaman & Tahfidz
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-2 rounded-pill fw-semibold" id="sains-tab" data-bs-toggle="pill" data-bs-target="#tab-sains" type="button" role="tab">
                            <i class="bi bi-gear-wide-connected me-1"></i> Sains & Pengembangan Diri
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="curriculumTabsContent">
                    {{-- Tab 1: Umum --}}
                    <div class="tab-pane fade show active" id="tab-umum" role="tabpanel">
                        <div class="card card-soft p-4 p-md-5">
                            <h4 class="fw-bold text-navy mb-3">Kelompok Mata Pelajaran Umum (Kurikulum Merdeka)</h4>
                            <p class="text-secondary mb-4">
                                Pembelajaran reguler sesuai kurikulum nasional dengan penekanan pada literasi konseptual, penalaran logis, dan kolaborasi aktif siswa:
                            </p>
                            <div class="row g-3">
                                @forelse($mapelUmum as $mu)
                                <div class="col-md-6">
                                    <div class="subject-item-box">
                                        <div class="subject-icon-box">
                                            <i class="bi {{ $mu->ikon ?: 'bi-calculator' }}"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">{{ $mu->judul }}</strong>
                                            <div class="text-muted small">{{ $mu->deskripsi ?: '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted">Belum ada mata pelajaran umum.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Tab 2: Keislaman --}}
                    <div class="tab-pane fade" id="tab-islam" role="tabpanel">
                        <div class="card card-soft p-4 p-md-5">
                            <h4 class="fw-bold text-navy mb-3">Kelompok Muatan Al-Qur'an & Diniyah</h4>
                            <p class="text-secondary mb-4">
                                Membekali santri dengan ilmu keislaman yang kokoh, hafalan Al-Qur'an mutqin, serta penanaman adab mulia dalam keseharian:
                            </p>
                            <div class="row g-3">
                                @forelse($mapelIslam as $mi)
                                <div class="col-md-6">
                                    <div class="subject-item-box">
                                        <div class="subject-icon-box">
                                            <i class="bi {{ $mi->ikon ?: 'bi-book' }}"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">{{ $mi->judul }}</strong>
                                            <div class="text-muted small">{{ $mi->deskripsi ?: '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted">Belum ada muatan keislaman.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Tab 3: Sains & Pengembangan Diri --}}
                    <div class="tab-pane fade" id="tab-sains" role="tabpanel">
                        <div class="card card-soft p-4 p-md-5">
                            <h4 class="fw-bold text-navy mb-3">Kelompok Sains Terapan & Pengembangan Diri</h4>
                            <p class="text-secondary mb-4">
                                Wadah akselerasi minat dan bakat khusus santri dalam bidang sains, riset, teknologi, serta kepemimpinan:
                            </p>
                            <div class="row g-3">
                                @forelse($mapelSains as $ms)
                                <div class="col-md-6">
                                    <div class="subject-item-box">
                                        <div class="subject-icon-box">
                                            <i class="bi {{ $ms->ikon ?: 'bi-laptop' }}"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">{{ $ms->judul }}</strong>
                                            <div class="text-muted small">{{ $ms->deskripsi ?: '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted">Belum ada muatan sains terapan.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TARGET CAPAIAN LULUSAN --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Profil Capaian Lulusan</h2>
            <p class="section-subtitle">Karakter dan kompetensi utama yang ditargetkan untuk setiap santri</p>
        </div>

        <div class="row g-4">
            @forelse($capaians as $index => $c)
            <div class="col-md-6 col-lg-3">
                <div class="card card-soft text-center p-4 h-100">
                    <div class="icon-circle bg-navy-soft mx-auto mb-3">
                        <i class="bi {{ $c->ikon ?: 'bi-award' }} fs-4 text-navy"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">{{ $c->judul }}</h5>
                    <p class="text-secondary small mb-0">{{ $c->deskripsi ?: '-' }}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted">Belum ada target capaian lulusan.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- KONSULTASI / CTA --}}
<section class="py-5 bg-navy text-white text-center" style="background: linear-gradient(135deg, #052e1c 0%, #0d5c3a 100%);">
    <div class="container py-4">
        <h2 class="fw-bold mb-3">Ingin Mengetahui Lebih Lanjut Tentang Kurikulum Kami?</h2>
        <p class="lead opacity-90 mx-auto mb-4" style="max-width: 650px;">
            Kami dengan senang hati menyambut pertanyaan dari bapak/ibu seputar sistem belajar, target tahfidz, dan kegiatan akademik santri.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            @if($profil && $profil->whatsapp)
            <a href="https://wa.me/{{ $profil->whatsapp }}" target="_blank" class="btn btn-light btn-pill fw-semibold">
                <i class="bi bi-whatsapp text-success me-1"></i> Hubungi Kami via WhatsApp
            </a>
            @endif
            <a href="{{ route('profil-sekolah') }}" class="btn btn-outline-light btn-pill">
                <i class="bi bi-building me-1"></i> Profil Sekolah
            </a>
        </div>
    </div>
</section>
@endsection
