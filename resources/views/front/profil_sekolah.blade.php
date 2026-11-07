@extends('layouts.main')
@section('title', 'Profil Sekolah')

@section('content')
<section class="py-5">
    <div class="container">

        {{-- HERO PROFIL --}}
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-5">
                <div class="rounded-4 overflow-hidden shadow-lg">
                    <img
                        src="{{ image_url($profil?->gambar, asset('assets/img/dummy/sekolah.png')) }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/sekolah.png') }}';"
                        alt="Foto Sekolah" class="img-fluid w-100" style="max-height:380px;object-fit:cover;">
                </div>
            </div>
            <div class="col-lg-7">
                @if($profil && $profil->akreditasi)
                    <span class="badge bg-warning text-dark mb-2 fs-6"><i class="bi bi-patch-check me-1"></i>Akreditasi {{ $profil->akreditasi }}</span>
                @endif
                <h1 class="fw-bold mb-2">{{ $profil->nama_sekolah ?? 'SMP Sains Al-Qur\'an Klakah' }}</h1>
                <p class="lead text-muted mb-4">{{ $profil->tagline ?? 'Membentuk Generasi Qur\'ani yang Cerdas, Mandiri, dan Berakhlak Mulia' }}</p>

                {{-- Quick Stats --}}
                <div class="row g-3 mb-4">
                    @if($profil && $profil->npsn)
                    <div class="col-6 col-md-3">
                        <div class="card card-soft text-center p-3">
                            <div class="fw-bold text-primary small">NPSN</div>
                            <div class="fw-semibold">{{ $profil->npsn }}</div>
                        </div>
                    </div>
                    @endif
                    @if($profil && $profil->tahun_berdiri)
                    <div class="col-6 col-md-3">
                        <div class="card card-soft text-center p-3">
                            <div class="fw-bold text-primary small">Berdiri</div>
                            <div class="fw-semibold">{{ $profil->tahun_berdiri }}</div>
                        </div>
                    </div>
                    @endif
                    @php
                        $displaySiswa = (isset($totalSiswa) && $totalSiswa > 0) ? $totalSiswa : ($profil->jumlah_siswa ?? 0);
                    @endphp
                    @if($displaySiswa > 0)
                    <div class="col-6 col-md-3">
                        <div class="card card-soft text-center p-3">
                            <div class="fw-bold text-primary small">Siswa Aktif</div>
                            <div class="fw-semibold">{{ number_format($displaySiswa, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('kurikulum.index') }}" class="btn btn-primary btn-pill">
                        <i class="bi bi-book-half me-1"></i>Kurikulum Sekolah
                    </a>
                    @if($profil && $profil->whatsapp)
                    <a href="https://wa.me/{{ $profil->whatsapp }}" target="_blank" class="btn btn-outline-success btn-pill">
                        <i class="bi bi-whatsapp me-1"></i>Hubungi Kami
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- DESKRIPSI --}}
        @if($profil && $profil->deskripsi)
        <div class="card card-soft p-4 mb-4">
            <h2 class="h5 fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Tentang Sekolah</h2>
            <p class="text-muted mb-0">{!! nl2br(e($profil->deskripsi)) !!}</p>
        </div>
        @endif

        {{-- VISI MISI --}}
        @if($profil && ($profil->visi || $profil->misi))
        <div class="row g-4 mb-5 align-items-stretch">
            @if($profil->visi)
            <div class="col-md-6">
                <div class="card card-soft visi-misi-card h-100 p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="visi-icon shadow-sm"><i class="bi bi-compass-fill"></i></div>
                        <div>
                            <span class="text-uppercase small fw-bold text-muted">Pandangan Ke Depan</span>
                            <h2 class="h5 fw-bold mb-0 text-navy">Visi Sekolah</h2>
                        </div>
                    </div>
                    <div class="visi-content p-3 rounded-4">
                        <p class="text-secondary mb-0 fst-italic">"{{ $profil->visi }}"</p>
                    </div>
                </div>
            </div>
            @endif
            @if($profil->misi)
            <div class="col-md-6">
                <div class="card card-soft visi-misi-card h-100 p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="misi-icon shadow-sm"><i class="bi bi-rocket-takeoff-fill"></i></div>
                        <div>
                            <span class="text-uppercase small fw-bold text-muted">Langkah Nyata</span>
                            <h2 class="h5 fw-bold mb-0 text-navy">Misi Sekolah</h2>
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                        @foreach(explode("\n", $profil->misi) as $line)
                            @if(trim($line))
                                @php $clean = preg_replace('/^\d+[\.\)]\s*/', '', trim($line)); @endphp
                                <li class="d-flex align-items-start gap-3">
                                    <div class="misi-bullet-icon flex-shrink-0 mt-1">
                                        <i class="bi bi-patch-check-fill"></i>
                                    </div>
                                    <span class="text-secondary">{{ $clean }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- SEJARAH --}}
        @if($profil && $profil->sejarah)
        <div class="card card-soft p-4 mb-4">
            <h2 class="h5 fw-bold mb-3"><i class="bi bi-clock-history text-primary me-2"></i>Sejarah Sekolah</h2>
            <p class="text-muted mb-0">{!! nl2br(e($profil->sejarah)) !!}</p>
        </div>
        @endif

        {{-- SAMBUTAN KEPALA SEKOLAH --}}
        @if($profil && $profil->sambutan_kepsek)
        @php
            $fotoKepsekUrl = null;
            if (isset($kepsek) && $kepsek && $kepsek->foto) {
                $fotoKepsekUrl = image_url($kepsek->foto);
            } elseif ($profil && $profil->foto_kepsek) {
                $fotoKepsekUrl = image_url($profil->foto_kepsek);
            } else {
                $fotoKepsekUrl = asset('assets/img/dummy/guru-pria.png');
            }
            $namaKepsek = (isset($kepsek) && $kepsek && $kepsek->nama) ? $kepsek->nama : ($profil->nama_kepsek ?? 'Kepala Sekolah');
        @endphp
        <div class="card card-soft p-4 mb-4">
            <h2 class="h5 fw-bold mb-4"><i class="bi bi-person-badge text-primary me-2"></i>Sambutan Kepala Sekolah</h2>
            <div class="row align-items-center g-4">
                <div class="col-md-3 text-center">
                    <img src="{{ $fotoKepsekUrl }}"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                         alt="{{ $namaKepsek }}"
                         class="rounded-circle shadow mb-2"
                         style="width:120px;height:120px;object-fit:cover;border:4px solid #e0f2fe;">
                    <div class="fw-semibold">{{ $namaKepsek }}</div>
                    <small class="text-muted">Kepala Sekolah</small>
                </div>
                <div class="col-md-9">
                    <blockquote class="blockquote">
                        <p class="text-muted fst-italic">"{{ $profil->sambutan_kepsek }}"</p>
                    </blockquote>
                </div>
            </div>
        </div>
        @endif

        {{-- KONTAK & LOKASI --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card card-soft p-4 h-100">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-telephone text-primary me-2"></i>Informasi Kontak</h2>
                    <ul class="list-unstyled mb-0">
                        @if($profil && $profil->alamat)
                        <li class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>{{ $profil->alamat }}</li>
                        @endif
                        @if($profil && $profil->telepon)
                        <li class="mb-2"><i class="bi bi-telephone text-primary me-2"></i>{{ $profil->telepon }}</li>
                        @endif
                        @if($profil && $profil->email)
                        <li class="mb-2"><i class="bi bi-envelope text-primary me-2"></i>{{ $profil->email }}</li>
                        @endif
                        @if($profil && $profil->whatsapp)
                        <li class="mb-2">
                            <a href="https://wa.me/{{ $profil->whatsapp }}" target="_blank" class="text-success text-decoration-none">
                                <i class="bi bi-whatsapp me-2"></i>WhatsApp
                            </a>
                        </li>
                        @endif
                    </ul>
                    <div class="mt-3 d-flex gap-2">
                        @if($profil && $profil->instagram)
                        <a href="{{ $profil->instagram }}" target="_blank" class="btn btn-outline-danger btn-sm btn-pill"><i class="bi bi-instagram me-1"></i>Instagram</a>
                        @endif
                        @if($profil && $profil->youtube)
                        <a href="{{ $profil->youtube }}" target="_blank" class="btn btn-outline-danger btn-sm btn-pill"><i class="bi bi-youtube me-1"></i>YouTube</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-soft p-3 h-100">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-map text-primary me-2"></i>Lokasi Sekolah</h2>
                    <div class="ratio ratio-4x3 rounded-3 overflow-hidden">
                        <iframe
                            src="{{ ($profil && $profil->maps_embed) ? $profil->maps_embed : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126425.49257840867!2d113.16242646611147!3d-8.019894112444272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd65bfaa61c7e27%3A0xa113f43ba4a9a688!2sYAHTADI%20ISLAMIC%20EDUCATION%20CENTER!5e0!3m2!1sid!2sid!4v1764706817064!5m2!1sid!2sid' }}"
                            style="border:0;" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
