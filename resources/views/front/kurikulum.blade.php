@extends('layouts.main')
@section('title', 'Kurikulum & Pembelajaran')

@section('content')
{{-- HERO KURIKULUM --}}
<section class="py-5 bg-light border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-3">
            <i class="bi bi-book-half me-1"></i> Sistem Pendidikan Terpadu
        </span>
        <h1 class="display-5 fw-bold text-navy mb-3">Kurikulum & Pembelajaran</h1>
        <p class="lead text-secondary mx-auto mb-0" style="max-width: 760px;">
            SMP Sains Al-Qur'an Klakah menerapkan kurikulum terintegrasi yang mengharmoniskan standar <strong>Kurikulum Merdeka</strong> dengan pendalaman <strong>Sains Modern Berbasis Riset</strong> serta keagungan <strong>Tahfidz Al-Qur'an</strong>.
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
            {{-- Pilar 1 --}}
            <div class="col-lg-4">
                <div class="card card-soft h-100 p-4 p-md-5 border-top border-4 border-primary">
                    <div class="icon-circle bg-navy-soft mb-4">
                        <i class="bi bi-mortarboard-fill fs-3 text-navy"></i>
                    </div>
                    <h3 class="h4 fw-bold text-navy mb-3">Kurikulum Merdeka</h3>
                    <p class="text-secondary mb-4">
                        Menerapkan standar nasional Kemendikbudristek dengan pendekatan pembelajaran berdiferensiasi, berbasis proyek (P5), serta berfokus pada penguatan nalar kritis, literasi, dan numerasi.
                    </p>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-secondary small">
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Pembelajaran Berbasis Proyek (P5)</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Asesmen Kompetensi & Bakat Siswa</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Fleksibilitas Eksplorasi Minat Belajar</li>
                    </ul>
                </div>
            </div>

            {{-- Pilar 2 --}}
            <div class="col-lg-4">
                <div class="card card-soft h-100 p-4 p-md-5 border-top border-4 border-info">
                    <div class="icon-circle bg-blue-soft mb-4">
                        <i class="bi bi-cpu fs-3 text-primary"></i>
                    </div>
                    <h3 class="h4 fw-bold text-navy mb-3">Sains & Riset Terapan</h3>
                    <p class="text-secondary mb-4">
                        Mengasah cara berpikir ilmiah santri melalui pembelajaran kontekstual, praktikum sains di laboratorium, pemanfaatan teknologi informatika, dan pembinaan olimpiade sains (OSN).
                    </p>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-secondary small">
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Praktikum Laboratorium Sains Rutin</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Bimbingan Riset & Karya Ilmiah Santri</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Pembinaan Olimpiade Sains & Matematika</li>
                    </ul>
                </div>
            </div>

            {{-- Pilar 3 --}}
            <div class="col-lg-4">
                <div class="card card-soft h-100 p-4 p-md-5 border-top border-4 border-success">
                    <div class="icon-circle bg-navy-soft mb-4">
                        <i class="bi bi-book-half fs-3 text-navy"></i>
                    </div>
                    <h3 class="h4 fw-bold text-navy mb-3">Tahfidz & Diniyah</h3>
                    <p class="text-secondary mb-4">
                        Program intensif hafalan Al-Qur'an dengan bimbingan ustadz berpengalaman, metode talaqqi & muroja'ah bersanad, serta penanaman adab islami dan pemahaman fiqih ibadah sehari-hari.
                    </p>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 text-secondary small">
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Target Hafalan Terukur & Berkala</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Tahsin Makharijul Huruf & Tajwid</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-check2 text-primary fw-bold"></i> Pembiasaan Ibadah & Karakter Qur'ani</li>
                    </ul>
                </div>
            </div>
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
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-calculator fs-4 text-primary"></i>
                                        <div><strong>Matematika</strong> <div class="text-muted small">Penalaran logis & numerasi terapan</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-flower1 fs-4 text-primary"></i>
                                        <div><strong>Ilmu Pengetahuan Alam (IPA)</strong> <div class="text-muted small">Fisika, Biologi, Kimia Dasar terintegrasi</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-chat-left-text fs-4 text-primary"></i>
                                        <div><strong>Bahasa Indonesia</strong> <div class="text-muted small">Kemampuan literasi, retorika, & penulisan</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-translate fs-4 text-primary"></i>
                                        <div><strong>Bahasa Inggris</strong> <div class="text-muted small">Komunikasi global & tata bahasa aktif</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-globe fs-4 text-primary"></i>
                                        <div><strong>Ilmu Pengetahuan Sosial (IPS)</strong> <div class="text-muted small">Geografi, sejarah, sosiologi, & ekonomi</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-shield-check fs-4 text-primary"></i>
                                        <div><strong>Pendidikan Pancasila (PPKn)</strong> <div class="text-muted small">Kewarganegaraan, hukum, & kebangsaan</div></div>
                                    </div>
                                </div>
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
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-book fs-4 text-success"></i>
                                        <div><strong>Tahfidzul Qur'an</strong> <div class="text-muted small">Halaqah setoran ziyadah & muroja'ah harian</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-mic fs-4 text-success"></i>
                                        <div><strong>Tahsin & Ilmu Tajwid</strong> <div class="text-muted small">Standarisasi makharijul huruf & hukum bacaan</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-fonts fs-4 text-success"></i>
                                        <div><strong>Bahasa Arab</strong> <div class="text-muted small">Kosakata, percakapan, & kaidah dasar bahasa Qur'an</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-heart-pulse fs-4 text-success"></i>
                                        <div><strong>Aqidah & Akhlak</strong> <div class="text-muted small">Penguatan tauhid & pembinaan budi pekerti luhur</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-water fs-4 text-success"></i>
                                        <div><strong>Fiqih Ibadah</strong> <div class="text-muted small">Tata cara bersuci, sholat, puasa, & adab islami</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-hourglass-split fs-4 text-success"></i>
                                        <div><strong>Sejarah Kebudayaan Islam (SKI)</strong> <div class="text-muted small">Teladan Rasulullah SAW, sahabat, & peradaban Islam</div></div>
                                    </div>
                                </div>
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
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-laptop fs-4 text-primary"></i>
                                        <div><strong>Informatika & Komputer</strong> <div class="text-muted small">Literasi digital, komputasi nalar, & aplikasi dasar</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-eyedropper fs-4 text-primary"></i>
                                        <div><strong>Karya Ilmiah Remaja (KIR)</strong> <div class="text-muted small">Metodologi riset sederhana & eksperimen sains</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-trophy fs-4 text-primary"></i>
                                        <div><strong>Klub Olimpiade Sains (OSN)</strong> <div class="text-muted small">Intensif pemantapan IPA & Matematika kompetisi</div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                        <i class="bi bi-palette fs-4 text-primary"></i>
                                        <div><strong>Seni & Ragam Ekstrakurikuler</strong> <div class="text-muted small">Pramuka, kaligrafi, bela diri, olahraga, & bahasa</div></div>
                                    </div>
                                </div>
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
            <div class="col-md-6 col-lg-3">
                <div class="card card-soft text-center p-4 h-100">
                    <div class="icon-circle bg-navy-soft mx-auto mb-3">
                        <i class="bi bi-book-half fs-4 text-navy"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">Hafal Al-Qur'an</h5>
                    <p class="text-secondary small mb-0">Memiliki hafalan Al-Qur'an mutqin dengan bacaan tajwid yang tertib dan berstandar.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-soft text-center p-4 h-100">
                    <div class="icon-circle bg-blue-soft mx-auto mb-3">
                        <i class="bi bi-lightbulb-fill fs-4 text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">Unggul dalam Sains</h5>
                    <p class="text-secondary small mb-0">Mampu berpikir logis, analitis, dan memiliki keterampilan riset ilmiah dasar yang kuat.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-soft text-center p-4 h-100">
                    <div class="icon-circle bg-navy-soft mx-auto mb-3">
                        <i class="bi bi-shield-check fs-4 text-navy"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">Berakhlak Qur'ani</h5>
                    <p class="text-secondary small mb-0">Meneladani akhlak Rasulullah SAW, disiplin ibadah, santun, dan mandiri dalam keseharian.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-soft text-center p-4 h-100">
                    <div class="icon-circle bg-blue-soft mx-auto mb-3">
                        <i class="bi bi-compass-fill fs-4 text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-navy mb-2">Siap Melanjutkan</h5>
                    <p class="text-secondary small mb-0">Memiliki bekal kompetensi akademik yang prima untuk bersaing di jenjang SLTA/MA unggulan.</p>
                </div>
            </div>
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
