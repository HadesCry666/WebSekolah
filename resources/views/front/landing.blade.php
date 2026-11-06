{{-- resources/views/front/landing.blade.php --}}
@extends('layouts.main')

@section('title', 'Beranda')

@section('content')

    {{-- ================= HERO SLIDESHOW ================= --}}
    <section class="hero-section">
        <div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                @foreach($sliders as $idx => $slide)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $idx }}" class="{{ $idx === 0 ? 'active' : '' }}" aria-label="Slide {{ $idx + 1 }}"></button>
                @endforeach
                @if($sliders->isEmpty())
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                @endif
            </div>
            <div class="carousel-inner">
                @forelse($sliders as $idx => $slide)
                <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                    <img src="{{ $slide->gambar ? asset('storage/'.$slide->gambar) : asset('assets/img/dummy/banner-'.($idx+1).'.png') }}"
                         class="d-block w-100"
                         alt="{{ $slide->judul ?? 'Slide' }}"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/banner-1.png') }}';">
                    <div class="carousel-caption">
                        <div class="container h-100 d-flex align-items-center">
                            <div class="hero-caption-inner">
                                <h1 class="hero-title">{{ $slide->judul ?? '' }}</h1>
                                <p class="hero-desc">{{ $slide->deskripsi ?? '' }}</p>
                                @if($slide->tombol_teks && $slide->tombol_url)
                                    <div class="mt-3">
                                        <a href="{{ $slide->tombol_url }}" class="hero-cta-btn">
                                            <span>{{ $slide->tombol_teks }}</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                {{-- Fallback if no sliders in DB --}}
                <div class="carousel-item active">
                    <img src="{{ asset('assets/img/dummy/banner-1.png') }}" class="d-block w-100" alt="SMP Sains Al-Qur'an Klakah">
                    <div class="carousel-caption">
                        <div class="container h-100 d-flex align-items-center">
                            <div class="hero-caption-inner">
                                <h1 class="hero-title">SMP Sains Al-Qur'an Klakah</h1>
                                <p class="hero-desc">Membentuk Generasi Qur'ani yang Cerdas, Mandiri, dan Berakhlak Mulia.</p>
                                <div class="mt-3">
                                    <a href="{{ route('profil-sekolah') }}" class="hero-cta-btn">
                                        <span>Profil Sekolah</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/dummy/banner-2.png') }}" class="d-block w-100" alt="Integrasi Sains dan Al-Qur'an">
                    <div class="carousel-caption">
                        <div class="container h-100 d-flex align-items-center">
                            <div class="hero-caption-inner">
                                <h1 class="hero-title">Integrasi Sains & Al-Qur'an</h1>
                                <p class="hero-desc">Menggabungkan keunggulan sains modern dengan kedalaman spiritual Al-Qur'an.</p>
                                <div class="mt-3">
                                    <a href="{{ route('landing') }}#program-unggulan" class="hero-cta-btn">
                                        <span>Program Unggulan</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/dummy/banner-3.png') }}" class="d-block w-100" alt="Prestasi Santri">
                    <div class="carousel-caption">
                        <div class="container h-100 d-flex align-items-center">
                            <div class="hero-caption-inner">
                                <h1 class="hero-title">Wadah Bakat & Prestasi</h1>
                                <p class="hero-desc">Mengasah minat, bakat riset sains, tahfidz Al-Qur'an, dan ragam ekstrakurikuler unggulan.</p>
                                <div class="mt-3">
                                    <a href="{{ route('informasi.kategori', 'prestasi') }}" class="hero-cta-btn">
                                        <span>Lihat Prestasi</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" aria-label="Previous">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" aria-label="Next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    {{-- ================= SAMBUTAN & STATISTIK ================= --}}
    <section class="section-sambutan-overlay">
        <div class="container">
            <div class="hero-overlay-card">
                <div class="row g-4 align-items-center">
                    {{-- Sambutan Kiri --}}
                    <div class="col-lg-7 col-xl-8">
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-4">
                            @php
                                $fotoKepsekUrl = null;
                                if (isset($kepsek) && $kepsek && $kepsek->foto) {
                                    $fotoKepsekUrl = asset('storage/'.$kepsek->foto);
                                } elseif ($profil && $profil->foto_kepsek) {
                                    $fotoKepsekUrl = asset('storage/'.$profil->foto_kepsek);
                                } else {
                                    $fotoKepsekUrl = asset('assets/img/dummy/kepsek.png');
                                }
                                $namaKepsek = (isset($kepsek) && $kepsek && $kepsek->nama) ? $kepsek->nama : ($profil->nama_kepsek ?? 'Kepala Sekolah');
                            @endphp
                            <div class="kepsek-avatar-wrap flex-shrink-0">
                                <img src="{{ $fotoKepsekUrl }}"
                                     class="kepsek-img shadow-sm"
                                     alt="{{ $namaKepsek }}"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';">
                                <div class="kepsek-icon-badge" title="Kepala Sekolah">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-2 text-navy fs-4">{{ $namaKepsek }}</h3>
                                <p class="text-secondary mb-3 kepsek-quote">
                                    "{{ Str::limit($profil->sambutan_kepsek ?? 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi SMP Sains Al-Qur\'an Klakah. Kami berkomitmen mencetak generasi yang cerdas, berkarakter, dan berjiwa Qur\'ani.', 220) }}"
                                </p>
                                <a href="{{ route('profil-sekolah') }}" class="btn-link-kepsek">
                                    <span>Selengkapnya tentang Sekolah</span>
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Statistik Kanan --}}
                    <div class="col-lg-5 col-xl-4">
                        <div class="stats-card-group">
                            <div class="stat-item-box">
                                <div class="stat-icon-circle bg-navy-soft">
                                    <i class="bi bi-person-workspace"></i>
                                </div>
                                <div>
                                    <div class="stat-number">{{ $statsSekolah->guru ?? 0 }}</div>
                                    <div class="stat-label">Guru & Staf Pengajar</div>
                                </div>
                            </div>

                            <div class="stat-item-box">
                                <div class="stat-icon-circle bg-blue-soft">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                                <div>
                                    <div class="stat-number">{{ ($statsSekolah->siswa && $statsSekolah->siswa > 0) ? number_format($statsSekolah->siswa, 0, ',', '.') : ($ekskul->count() ?? '6+') }}</div>
                                    <div class="stat-label">{{ ($statsSekolah->siswa && $statsSekolah->siswa > 0) ? 'Peserta Didik Aktif' : 'Ekstrakurikuler Unggulan' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= VISI & MISI ================= --}}
    @if($profil && ($profil->visi || $profil->misi))
    <section class="py-5 bg-light" id="visi-misi">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Visi & Misi</h2>
                <p class="section-subtitle">Arah dan komitmen pendidikan di SMP Sains Al-Qur'an Klakah</p>
            </div>
            <div class="row g-4 align-items-stretch">
                @if($profil->visi)
                <div class="col-lg-6">
                    <div class="card card-soft visi-misi-card h-100 p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="visi-icon shadow-sm">
                                <i class="bi bi-compass-fill"></i>
                            </div>
                            <div>
                                <span class="text-uppercase small fw-bold text-muted letter-spacing-1">Pandangan Ke Depan</span>
                                <h3 class="h4 fw-bold mb-0 text-navy">Visi Sekolah</h3>
                            </div>
                        </div>
                        <div class="visi-content p-4 rounded-4 shadow-xs">
                            <p class="lead fs-6 text-secondary mb-0 fst-italic">
                                "{{ $profil->visi }}"
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                @if($profil->misi)
                <div class="col-lg-6">
                    <div class="card card-soft visi-misi-card h-100 p-4 p-md-5">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="misi-icon shadow-sm">
                                <i class="bi bi-rocket-takeoff-fill"></i>
                            </div>
                            <div>
                                <span class="text-uppercase small fw-bold text-muted letter-spacing-1">Langkah Nyata</span>
                                <h3 class="h4 fw-bold mb-0 text-navy">Misi Sekolah</h3>
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
        </div>
    </section>
    @endif

    {{-- ================= PROGRAM UNGGULAN ================= --}}
    @if($programUnggulan->count())
    <section class="py-5" id="program-unggulan">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Program Unggulan</h2>
                <p class="section-subtitle">Keunggulan akademik, keislaman, tahfiz, dan teknologi</p>
            </div>
            <div class="row g-4">
                @foreach($programUnggulan as $prog)
                <div class="col-md-6 col-lg-3">
                    <div class="card card-soft h-100 text-center p-4 program-card">
                        <div class="mb-3">
                            <div class="icon-circle-lg bg-primary-soft mx-auto">
                                <i class="bi {{ $prog->ikon ?? 'bi-star' }} fs-1 text-primary"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold">{{ $prog->nama }}</h5>
                        <p class="text-muted small">{{ Str::limit($prog->deskripsi, 120) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= INFORMASI / BERITA ================= --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                <div style="min-width: 0; flex: 1;">
                    <h2 class="section-title mb-1">Informasi, Berita & Prestasi</h2>
                    <p class="section-subtitle mb-0 text-truncate">Informasi, berita & prestasi siswa</p>
                </div>
                <a href="{{ route('informasi.index') }}" class="btn btn-outline-primary btn-pill flex-shrink-0">
                    Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="info-scroll">
                @forelse($artikel as $item)
                    <div class="info-item">
                        <div class="card card-soft info-card-hover h-100">
                            <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('assets/img/dummy/artikel-dummy.png') }}"
                                 onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/artikel-dummy.png') }}';"
                                 alt="{{ $item->judul }}">
                            <div class="card-body d-flex flex-column">
                                <small class="text-uppercase text-muted mb-1">
                                    {{ $item->kategori === 'prestasi' ? 'Prestasi' : 'Berita' }}
                                </small>
                                <h5 class="card-title">{{ $item->judul }}</h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($item->deskripsi_berita, 120) }}
                                </p>
                                <a href="{{ route('informasi.detail', $item->id) }}" class="stretched-link text-primary small">
                                    Baca selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted">Belum ada artikel yang ditampilkan.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= PENGUMUMAN & AGENDA ================= --}}
    @if($pengumuman->count() || $agenda->count())
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                {{-- PENGUMUMAN --}}
                @if($pengumuman->count())
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="section-title mb-0"><i class="bi bi-megaphone me-2 text-primary"></i>Pengumuman</h2>
                        <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-primary btn-sm btn-pill">Semua</a>
                    </div>
                    <div class="list-group">
                        @foreach($pengumuman as $p)
                        <a href="{{ route('pengumuman.detail', $p->id) }}" class="list-group-item list-group-item-action border-0 rounded mb-2 shadow-sm">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1 fw-semibold">{{ Str::limit($p->judul, 50) }}</h6>
                                <small class="text-muted">{{ $p->tanggal_publikasi->format('d M Y') }}</small>
                            </div>
                            <p class="mb-0 text-muted small">{{ Str::limit(strip_tags($p->isi), 80) }}</p>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- AGENDA --}}
                @if($agenda->count())
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="section-title mb-0"><i class="bi bi-calendar-event me-2 text-success"></i>Agenda</h2>
                        <a href="{{ route('agenda.index') }}" class="btn btn-outline-success btn-sm btn-pill">Semua</a>
                    </div>
                    <div class="list-group">
                        @foreach($agenda as $ag)
                        <div class="list-group-item border-0 rounded mb-2 shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="agenda-date-box text-center">
                                    <div class="fw-bold fs-4 text-primary">{{ $ag->tanggal_mulai->format('d') }}</div>
                                    <div class="small text-muted">{{ $ag->tanggal_mulai->translatedFormat('M Y') }}</div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $ag->judul }}</h6>
                                    <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $ag->lokasi ?? 'Sekolah' }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ================= TENAGA PENDIDIK ================= --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                <div style="min-width: 0; flex: 1;">
                    <h2 class="section-title mb-1">Tenaga Pendidik</h2>
                    <p class="section-subtitle mb-0 text-truncate">Guru dan staf SMP Sains Al-Qur'an Klakah</p>
                </div>
                <a href="{{ route('tenaga-pendidik.index') }}" class="btn btn-outline-primary btn-pill flex-shrink-0">
                    Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="guru-panel" data-role="guru">
                <div class="guru-scroll">
                    @forelse($guru as $g)
                        <div class="guru-item">
                            <div class="card card-soft guru-card h-100 text-center position-relative">
                                <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                                <img src="{{ $g->foto ? asset('storage/'.$g->foto) : ($g->jenis_kelamin == 'Perempuan' ? asset('assets/img/dummy/guru-wanita.png') : asset('assets/img/dummy/guru-pria.png')) }}"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                                     alt="{{ $g->nama }}" class="img-fluid">
                                <div class="card-body">
                                    <div class="fw-semibold mb-1">{{ $g->nama }}</div>
                                    <div class="small text-muted">{{ $g->mata_pelajaran ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted w-100">Belum ada data guru.</div>
                    @endforelse
                </div>
            </div>
            <div class="guru-panel d-none" data-role="tata_usaha">
                <div class="guru-scroll">
                    @forelse($tataUsaha as $g)
                        <div class="guru-item">
                            <div class="card card-soft guru-card h-100 text-center position-relative">
                                <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                                <img src="{{ $g->foto ? asset('storage/'.$g->foto) : ($g->jenis_kelamin == 'Perempuan' ? asset('assets/img/dummy/guru-wanita.png') : asset('assets/img/dummy/guru-pria.png')) }}"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                                     alt="{{ $g->nama }}" class="img-fluid">
                                <div class="card-body">
                                    <div class="fw-semibold mb-1">{{ $g->nama }}</div>
                                    <div class="small text-muted">{{ $g->mata_pelajaran ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted w-100">Belum ada data tata usaha.</div>
                    @endforelse
                </div>
            </div>
            <div class="guru-panel d-none" data-role="ustadz">
                <div class="guru-scroll">
                    @forelse($ustadz as $g)
                        <div class="guru-item">
                            <div class="card card-soft guru-card h-100 text-center position-relative">
                                <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                                <img src="{{ $g->foto ? asset('storage/'.$g->foto) : ($g->jenis_kelamin == 'Perempuan' ? asset('assets/img/dummy/guru-wanita.png') : asset('assets/img/dummy/guru-pria.png')) }}"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                                     alt="{{ $g->nama }}" class="img-fluid">
                                <div class="card-body">
                                    <div class="fw-semibold mb-1">{{ $g->nama }}</div>
                                    <div class="small text-muted">{{ $g->mata_pelajaran ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted w-100">Belum ada data ustadz.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ================= FASILITAS ================= --}}
    @if($fasilitas->count())
    <section class="py-5 bg-light" id="fasilitas">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Fasilitas Sekolah</h2>
                <p class="section-subtitle">Sarana dan prasarana penunjang kegiatan belajar mengajar</p>
            </div>
            <div class="row g-4">
                @foreach($fasilitas as $fas)
                <div class="col-md-4 col-lg-3">
                    <div class="card card-soft h-100 text-center p-3">
                        @if($fas->foto)
                            <img src="{{ asset('storage/'.$fas->foto) }}" alt="{{ $fas->nama }}" class="rounded mb-3" style="height:150px;object-fit:cover;width:100%;">
                        @else
                            <div class="mb-3 py-4"><i class="bi {{ $fas->ikon ?? 'bi-building' }} fs-1 text-primary"></i></div>
                        @endif
                        <h6 class="fw-bold mb-1">{{ $fas->nama }}</h6>
                        @if($fas->deskripsi)
                            <p class="small text-muted mb-0">{{ Str::limit($fas->deskripsi, 80) }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= GALERI ================= --}}
    @if($galeri->count())
    <section class="py-5" id="galeri">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                <div style="min-width: 0; flex: 1;">
                    <h2 class="section-title mb-1">Galeri</h2>
                    <p class="section-subtitle mb-0 text-truncate">Dokumentasi kegiatan sekolah</p>
                </div>
                <a href="{{ route('galeri.index') }}" class="btn btn-outline-primary btn-pill flex-shrink-0">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-3">
                @foreach($galeri as $g)
                <div class="col-6 col-md-3">
                    <div class="galeri-thumb rounded overflow-hidden shadow-sm">
                        @if($g->tipe == 'foto' && $g->file)
                            <img src="{{ asset('storage/'.$g->file) }}" alt="{{ $g->judul }}" class="w-100" style="height:180px;object-fit:cover;">
                        @elseif($g->tipe == 'video' && $g->url_video)
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $g->url_video }}" allowfullscreen loading="lazy"></iframe>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= PRESTASI ================= --}}
    @if($prestasi->count())
    <section class="py-5 bg-light" id="prestasi">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Prestasi Sekolah</h2>
                <p class="section-subtitle">Pencapaian siswa dalam berbagai bidang</p>
            </div>
            <div class="row g-4">
                @foreach($prestasi as $p)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-soft h-100">
                        @if($p->foto)
                            <img src="{{ asset('storage/'.$p->foto) }}" alt="{{ $p->nama }}" style="height:200px;object-fit:cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex gap-2 mb-2">
                                @if($p->kategori)<span class="badge bg-primary">{{ ucfirst($p->kategori) }}</span>@endif
                                @if($p->tingkat)<span class="badge bg-success">{{ ucfirst($p->tingkat) }}</span>@endif
                            </div>
                            <h6 class="fw-bold">{{ $p->nama }}</h6>
                            @if($p->deskripsi)
                                <p class="small text-muted mb-1">{{ Str::limit($p->deskripsi, 100) }}</p>
                            @endif
                            @if($p->tanggal)
                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $p->tanggal->format('d M Y') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= KURIKULUM & PEMBELAJARAN ================= --}}
    <section class="py-5 kurikulum-section" id="kurikulum-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white mb-4 mb-lg-0">
                    <span class="badge bg-warning text-dark mb-2"><i class="bi bi-book-half me-1"></i> Kurikulum Terpadu</span>
                    <h2 class="fw-bold mb-3">Integrasi Sains Modern & Nilai-Nilai Al-Qur'an</h2>
                    <p class="mb-4 opacity-90">
                        SMP Sains Al-Qur'an Klakah memadukan Kurikulum Merdeka nasional dengan pembinaan tahfidz Al-Qur'an bersanad, sains praktis berbasis riset, serta pembentukan akhlak mulia generasi Qur'ani.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('kurikulum.index') }}" class="btn btn-light btn-pill fw-semibold">
                            Pelajari Kurikulum <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <a href="{{ route('profil-sekolah') }}" class="btn btn-outline-light btn-pill">
                            Profil Sekolah <i class="bi bi-info-circle ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 p-4 text-dark bg-white">
                        <h5 class="fw-bold text-navy mb-3"><i class="bi bi-stars text-primary me-2"></i>Pilar Keunggulan Pembelajaran</h5>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                            <li class="d-flex align-items-start gap-3">
                                <div class="misi-bullet-icon flex-shrink-0 mt-1"><i class="bi bi-patch-check-fill"></i></div>
                                <div><strong class="text-navy">Kurikulum Merdeka:</strong> Pembelajaran berdiferensiasi dan berfokus pada pengembangan nalar kritis siswa.</div>
                            </li>
                            <li class="d-flex align-items-start gap-3">
                                <div class="misi-bullet-icon flex-shrink-0 mt-1"><i class="bi bi-patch-check-fill"></i></div>
                                <div><strong class="text-navy">Tahfidz & Diniyah:</strong> Program hafalan Qur'an terstruktur dengan metode talaqqi dan muroja'ah berkala.</div>
                            </li>
                            <li class="d-flex align-items-start gap-3">
                                <div class="misi-bullet-icon flex-shrink-0 mt-1"><i class="bi bi-patch-check-fill"></i></div>
                                <div><strong class="text-navy">Sains & Praktikum:</strong> Pengalaman belajar aplikatif melalui eksperimen laboratorium dan riset santri.</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= EKSTRAKURIKULER ================= --}}
    <section class="py-5" id="section-ekskul">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                <div style="min-width: 0; flex: 1;">
                    <h2 class="section-title mb-1">Ekstrakurikuler</h2>
                    <p class="section-subtitle mb-0 text-truncate">Kegiatan pengembangan bakat siswa</p>
                </div>
                <div class="d-flex gap-2 flex-shrink-0">
                    <button class="btn btn-outline-secondary btn-sm rounded-circle btn-ekskul-prev"><i class="bi bi-arrow-left"></i></button>
                    <button class="btn btn-outline-secondary btn-sm rounded-circle btn-ekskul-next"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
            <div class="ekskul-scroll" id="ekskulScroll">
                @forelse($ekskul as $item)
                    <div class="ekskul-item">
                        <div class="card card-soft h-100 text-center position-relative">
                            <a href="{{ route('ekstrakulikuler.detail', $item->id) }}" class="stretched-link"></a>
                            <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('assets/img/dummy/ekskul-dummy.png') }}"
                                 onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/ekskul-dummy.png') }}';"
                                 alt="{{ $item->judul }}">
                            <div class="card-body bg-primary text-white">
                                <h5 class="mb-0 fw-bold">{{ $item->judul ?? 'Ekstrakurikuler' }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ekskul-item">
                        <div class="card card-soft h-100 text-center">
                            <img src="{{ asset('assets/img/dummy/ekskul-dummy.png') }}" alt="Belum Ada Data">
                            <div class="card-body bg-primary text-white">
                                <h5 class="mb-0">Belum ada data ekstrakurikuler</h5>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ekskul slider
            const scrollEl = document.getElementById('ekskulScroll');
            if (scrollEl) {
                const prevBtn = document.querySelector('.btn-ekskul-prev');
                const nextBtn = document.querySelector('.btn-ekskul-next');
                function getScrollAmount() {
                    const card = scrollEl.querySelector('.ekskul-item');
                    if (!card) return scrollEl.clientWidth;
                    return (card.offsetWidth + 24) * 3;
                }
                if (prevBtn) prevBtn.addEventListener('click', function () { scrollEl.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' }); });
                if (nextBtn) nextBtn.addEventListener('click', function () { scrollEl.scrollBy({ left: getScrollAmount(), behavior: 'smooth' }); });
            }

            // Guru panel auto-rotate
            const panels = Array.from(document.querySelectorAll('.guru-panel'));
            if (panels.length) {
                let currentIdx = 0;
                let scrollIntervalId = null;
                function startSmoothScroll() {
                    if (scrollIntervalId) { clearInterval(scrollIntervalId); scrollIntervalId = null; }
                    const activePanel = panels[currentIdx];
                    if (!activePanel) return;
                    const scrollEl = activePanel.querySelector('.guru-scroll');
                    if (!scrollEl) return;
                    scrollIntervalId = setInterval(function () {
                        if (scrollEl.scrollWidth <= scrollEl.clientWidth) return;
                        if (scrollEl.scrollLeft + scrollEl.clientWidth + 2 >= scrollEl.scrollWidth) { scrollEl.scrollLeft = 0; }
                        else { scrollEl.scrollLeft += 1; }
                    }, 20);
                }
                function showPanel(idx) {
                    currentIdx = idx;
                    panels.forEach((p, i) => { p.classList.toggle('d-none', i !== idx); });
                    startSmoothScroll();
                }
                showPanel(0);
                setInterval(function () { showPanel((currentIdx + 1) % panels.length); }, 5000);
            }
        });
    </script>

@endsection
