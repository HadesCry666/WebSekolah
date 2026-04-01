{{-- resources/views/landing.blade.php --}}
@extends('layouts.main')

@section('title', 'Beranda')

@section('content')

    {{-- ================= HERO + SAMBUTAN & STATISTIK ================= --}}
    <section class="hero-section">
        <div class="container">
            <div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://via.placeholder.com/1200x320?text=Banner+1" class="d-block w-100" alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/1200x320?text=Banner+2" class="d-block w-100" alt="Banner 2">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="hero-overlay-card p-4 p-md-5 d-flex flex-column flex-lg-row gap-4 align-items-center">
                <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <img src="https://via.placeholder.com/140x140?text=Kepsek" class="rounded-circle" alt="Kepala Sekolah" width="140" height="140">
                    <div>
                        <small class="text-uppercase text-muted fw-semibold">Sambutan Kepala Sekolah</small>
                        <h3 class="mb-1">Nama Kepala Sekolah</h3>
                        <p class="mb-2 text-muted">
                            Assalamu’alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi
                            SMPN Sains Al-Qur'an Klakah. Kami berkomitmen mencetak lulusan yang berakhlak mulia,
                            cerdas dan berprestasi.
                        </p>
                        {{-- <a href="#" class="btn btn-outline-primary btn-sm btn-pill">
                            Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="d-flex flex-row flex-lg-column gap-4 text-center justify-content-center">
                    <div>
                        <div class="badge-stat text-uppercase">Guru & Staf</div>
                        <div class="stat-value">{{ $statsSekolah->guru ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="badge-stat text-uppercase">Siswa</div>
                        <div class="stat-value">
                            {{ isset($statsSekolah->siswa) ? number_format($statsSekolah->siswa, 0, ',', '.') : 0 }}
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= INFORMASI / ARTIKEL & PRESTASI ================= --}}
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="section-title">Informasi, Berita & Prestasi</h2>
                    <p class="section-subtitle mb-0">Informasi, berita & prestasi siswa</p>
                </div>
                <a href="{{ route('informasi.index') }}" class="btn btn-outline-primary btn-pill">
                    Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="info-scroll">
                @forelse($artikel as $item)
                    <div class="info-item">
                        <div class="card card-soft info-card-hover h-100">
                            <img
                                src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/600x220?text=Artikel' }}"
                                alt="{{ $item->judul }}"
                            >

                            <div class="card-body d-flex flex-column">
                                <small class="text-uppercase text-muted mb-1">
                                    {{ $item->kategori === 'prestasi' ? 'Prestasi' : 'Berita' }}
                                </small>

                                <h5 class="card-title">{{ $item->judul }}</h5>

                                <p class="card-text text-muted small flex-grow-1">
                                    {{ \Illuminate\Support\Str::limit($item->deskripsi_berita, 120) }}
                                </p>

                                <a href="{{ route('informasi.detail', $item->id) }}"
                                   class="stretched-link text-primary small">
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

   {{-- ============== TENAGA PENDIDIK (SLIDE PER JABATAN) ============== --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title">Tenaga Pendidik</h2>
                <p class="section-subtitle mb-0">
                    Tenaga pendidik SMPN Sains Al-Qur'an Klakah
                </p>
            </div>
            <a href="{{ route('tenaga-pendidik.index') }}" class="btn btn-outline-primary btn-pill">
                Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        {{-- PANEL GURU --}}
        <div class="guru-panel" data-role="guru">
            <div class="guru-scroll">
                @forelse($guru as $g)
                    <div class="guru-item">
                        <div class="card card-soft guru-card h-100 text-center position-relative">
                            <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                            <img
                                src="{{ $g->foto ? asset('storage/'.$g->foto) : 'https://via.placeholder.com/400x260?text=Guru' }}"
                                alt="{{ $g->nama }}"
                                class="img-fluid"
                            >
                            <div class="card-body">
                                <div class="fw-semibold mb-1">{{ $g->nama }}</div>
                                <div class="small text-muted">
                                    {{ $g->mata_pelajaran ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted w-100">
                        Belum ada data guru.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PANEL TATA USAHA --}}
        <div class="guru-panel d-none" data-role="tata_usaha">
            <div class="guru-scroll">
                @forelse($tataUsaha as $g)
                    <div class="guru-item">
                        <div class="card card-soft guru-card h-100 text-center position-relative">
                            <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                            <img
                                src="{{ $g->foto ? asset('storage/'.$g->foto) : 'https://via.placeholder.com/400x260?text=Guru' }}"
                                alt="{{ $g->nama }}"
                                class="img-fluid"
                            >
                            <div class="card-body">
                                <div class="fw-semibold mb-1">{{ $g->nama }}</div>
                                <div class="small text-muted">
                                    {{ $g->mata_pelajaran ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted w-100">
                        Belum ada data tata usaha.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PANEL USTADZ --}}
        <div class="guru-panel d-none" data-role="ustadz">
            <div class="guru-scroll">
                @forelse($ustadz as $g)
                    <div class="guru-item">
                        <div class="card card-soft guru-card h-100 text-center position-relative">
                            <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                            <img
                                src="{{ $g->foto ? asset('storage/'.$g->foto) : 'https://via.placeholder.com/400x260?text=Guru' }}"
                                alt="{{ $g->nama }}"
                                class="img-fluid"
                            >
                            <div class="card-body">
                                <div class="fw-semibold mb-1">{{ $g->nama }}</div>
                                <div class="small text-muted">
                                    {{ $g->mata_pelajaran ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted w-100">
                        Belum ada data ustadz.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</section>



{{-- ================= EKSTRAKURIKULER ================= --}}
<section class="py-5" id="section-ekskul">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title">Ekstrakurikuler</h2>
                <p class="section-subtitle mb-0">
                    Ekstrakurikuler SMPN Sains Al-Qur'an Klakah
                </p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm rounded-circle btn-ekskul-prev">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm rounded-circle btn-ekskul-next">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <div class="ekskul-scroll" id="ekskulScroll">
            @forelse($ekskul as $item)
                <div class="ekskul-item">
                    <div class="card card-soft h-100 text-center position-relative">

                        {{-- FULL CARD BISA DIKLIK --}}
                   <a href="{{ route('ekstrakulikuler.detail', $item->id) }}" class="stretched-link"></a>
                        <img
                            src="{{ $item->gambar
                                ? asset('storage/'.$item->gambar)
                                : 'https://via.placeholder.com/600x220?text=Ekstrakurikuler' }}"
                            alt="{{ $item->judul }}"
                        >

                        <div class="card-body bg-primary text-white">
                            <h5 class="mb-0 fw-bold">
                                {{ $item->judul ?? 'Ekstrakurikuler' }}
                            </h5>
                        </div>

                    </div>
                </div>
            @empty
                <div class="ekskul-item">
                    <div class="card card-soft h-100 text-center">
                        <img src="https://via.placeholder.com/600x220?text=Belum+Ada+Data">
                        <div class="card-body bg-primary text-white">
                            <h5 class="mb-0">Belum ada data ekstrakurikuler</h5>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>



    {{-- JS khusus ekskul slider (boleh dibiarkan di sini) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const scrollEl = document.getElementById('ekskulScroll');
            if (!scrollEl) return;

            const prevBtn = document.querySelector('.btn-ekskul-prev');
            const nextBtn = document.querySelector('.btn-ekskul-next');

            function getScrollAmount() {
                const card = scrollEl.querySelector('.ekskul-item');
                if (!card) return scrollEl.clientWidth;
                const gap = 24;
                return (card.offsetWidth + gap) * 3;
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    scrollEl.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    scrollEl.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
                });
            }
        });
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    // KUMPULKAN SEMUA PANEL GURU (Guru, TU, Ustadz)
    const panels = Array.from(document.querySelectorAll('.guru-panel'));
    if (!panels.length) return;

    let currentIdx = 0;
    let scrollIntervalId = null;

    // Fungsi untuk mulai smooth scroll pada panel yang aktif
    function startSmoothScroll() {
        // stop interval lama (kalau ada)
        if (scrollIntervalId) {
            clearInterval(scrollIntervalId);
            scrollIntervalId = null;
        }

        const activePanel = panels[currentIdx];
        if (!activePanel) return;

        const scrollEl = activePanel.querySelector('.guru-scroll');
        if (!scrollEl) return;

        const speed = 1; // px per step

        scrollIntervalId = setInterval(function () {
            // kalau konten tidak lebih lebar dari container, tidak perlu scroll
            if (scrollEl.scrollWidth <= scrollEl.clientWidth) return;

            if (scrollEl.scrollLeft + scrollEl.clientWidth + 2 >= scrollEl.scrollWidth) {
                // kalau sudah mentok kanan, balik ke awal
                scrollEl.scrollLeft = 0;
            } else {
                scrollEl.scrollLeft += speed;
            }
        }, 20);
    }

    // Fungsi untuk menampilkan panel sesuai index
    function showPanel(idx) {
        currentIdx = idx;

        panels.forEach((p, i) => {
            p.classList.toggle('d-none', i !== idx);
        });

        // setiap ganti panel, mulai ulang smooth scroll-nya
        startSmoothScroll();
    }

    // awal: tampilkan panel pertama (Guru)
    showPanel(0);

    // AUTO GANTI ROLE SETIAP 8 DETIK
    setInterval(function () {
        const nextIdx = (currentIdx + 1) % panels.length;
        showPanel(nextIdx);
    }, 5000);
});
</script>




@endsection
