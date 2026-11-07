@extends('layouts.main')

@section('title', 'Panduan & Akses Raport Digital Siswa')

@section('content')

{{-- ================= HERO BANNER ================= --}}
<section class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #0d5c3a 0%, #15803d 50%, #166534 100%); overflow: hidden;">
    {{-- Background Pattern --}}
    <div style="position: absolute; top: -50px; right: -50px; width: 320px; height: 320px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -80px; left: -80px; width: 360px; height: 360px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 70%); pointer-events: none;"></div>

    <div class="container py-4 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 text-center text-lg-start">
                <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 rounded-pill mb-3" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.5px;">
                    <i class="bi bi-file-earmark-pdf-fill text-warning me-1"></i> {{ $settings['raport_hero_badge'] ?? 'Layanan E-Raport Digital' }}
                </span>
                <h1 class="display-6 fw-bold mb-3 text-white" style="letter-spacing: -0.5px; line-height: 1.25;">
                    {{ $settings['raport_hero_judul'] ?? 'Panduan & Akses Raport Digital Siswa' }}
                </h1>
                <p class="lead text-white-50 mb-4" style="font-size: 1.05rem; max-width: 680px;">
                    {{ $settings['raport_hero_subjudul'] ?? 'Layanan resmi informasi tata cara dan pengunduhan dokumen raport hasil belajar peserta didik SMP Sains Al-Qur\'an Klakah secara mudah, cepat, dan transparan.' }}
                </p>

                {{-- TOMBOL AKSI UTAMA --}}
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start align-items-center">
                    @if($isSiswa)
                        <a href="{{ route('siswa.raport.index') }}" class="btn btn-warning btn-lg fw-bold px-4 py-3 shadow-lg rounded-pill d-inline-flex align-items-center">
                            <i class="bi bi-folder-check fs-5 me-2"></i>
                            <span>Buka Raport Saya ({{ auth()->user()->name }})</span>
                        </a>
                    @else
                        <a href="{{ route('login.index') }}" class="btn btn-warning btn-lg fw-bold px-4 py-3 shadow-lg rounded-pill d-inline-flex align-items-center">
                            <i class="bi bi-box-arrow-in-right fs-5 me-2"></i>
                            <span>{{ $settings['raport_btn_login_text'] ?? 'Login Siswa & Unduh Raport' }}</span>
                        </a>
                    @endif

                    <a href="#tutorial-langkah" class="btn btn-outline-light btn-lg fw-semibold px-4 py-3 rounded-pill d-inline-flex align-items-center">
                        <i class="bi bi-play-circle fs-5 me-2"></i>
                        <span>Lihat Tutorial Unduh</span>
                    </a>

                    @php
                        $nomorWa = $settings['raport_kontak_wa'] ?? ($profil->whatsapp ?? '');
                        $cleanWa = preg_replace('/[^0-9]/', '', $nomorWa);
                        if (str_starts_with($cleanWa, '0')) {
                            $cleanWa = '62' . substr($cleanWa, 1);
                        }
                    @endphp
                    @if($cleanWa)
                    <a href="https://wa.me/{{ $cleanWa }}?text=Assalamu%27alaikum%20Admin%20SMP%20Sains%20Al-Qur%27an%2C%20saya%20butuh%20bantuan%20terkait%20akses%20dan%20download%20raport%20siswa." 
                       target="_blank" 
                       class="btn btn-light btn-lg fw-semibold px-4 py-3 rounded-pill d-inline-flex align-items-center text-success">
                        <i class="bi bi-whatsapp fs-5 me-2"></i>
                        <span>Bantuan Helpdesk</span>
                    </a>
                    @endif
                </div>

                {{-- Hint kredensial login --}}
                <div class="mt-4 d-inline-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-2 rounded-pill text-white" style="font-size: 0.82rem;">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <span>Kredensial Siswa: Masuk menggunakan <strong>NISN</strong> (Username) dan <strong>NIK</strong> (Password).</span>
                </div>
            </div>

            <div class="col-lg-4 d-none d-lg-block text-center">
                <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                    <div class="mb-3" style="width: 72px; height: 72px; margin: 0 auto; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-file-earmark-check-fill text-warning fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">E-Raport Terintegrasi</h5>
                    <p class="text-white-50 small mb-3">
                        Dokumen nilai resmi hasil belajar kurikulum terpadu (Kurikulum Merdeka, Tahfidz & Sains).
                    </p>
                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.15); text-align: left;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-white-50">Format File:</span>
                            <span class="badge bg-danger text-white">PDF Dokumen</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-white-50">Akses Unduh:</span>
                            <span class="badge bg-success text-white">Online 24 Jam</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-white-50">Keamanan:</span>
                            <span class="badge bg-info text-white">Otentikasi NISN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= CARD INFORMASI JADWAL ================= --}}
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border-left: 5px solid #16a34a !important;">
            <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(22, 163, 74, 0.1); color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h5 class="fw-bold mb-0 text-dark">{{ $settings['raport_jadwal_title'] ?? 'Jadwal Rilis & Pembagian Raport Semester' }}</h5>
                            <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-2 py-1 rounded">
                                <i class="bi bi-broadcast me-1"></i> {{ $settings['raport_jadwal_status'] ?? 'Aktif / Terbuka' }}
                            </span>
                        </div>
                        <p class="text-muted mb-0 small" style="max-width: 720px;">
                            {{ $settings['raport_jadwal_desc'] ?? 'Raport digital dapat diakses dan diunduh secara mandiri oleh siswa dan wali santri 24 jam non-stop setelah resmi dipublikasikan oleh pihak sekolah.' }}
                        </p>
                    </div>
                </div>

                <div>
                    @if($isSiswa)
                        <a href="{{ route('siswa.raport.index') }}" class="btn btn-success fw-semibold px-4 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Portal Siswa
                        </a>
                    @else
                        <a href="{{ route('login.index') }}" class="btn btn-success fw-semibold px-4 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= SECTION TUTORIAL LANGKAH ================= --}}
<section class="py-5 bg-white" id="tutorial-langkah">
    <div class="container py-3">
        <div class="text-center mb-5">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-2 fw-semibold" style="font-size: 0.8rem;">
                <i class="bi bi-info-circle-fill me-1"></i> Langkah Mudah
            </span>
            <h2 class="section-title">Tata Cara Mengunduh Raport Digital</h2>
            <p class="section-subtitle mx-auto" style="max-width: 650px;">
                Ikuti 4 langkah sederhana berikut untuk mendapatkan dokumen raport hasil belajar peserta didik secara instan
            </p>
        </div>

        <div class="row g-4 mb-5">
            {{-- LANGKAH 1 --}}
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 position-relative" style="background: #fdfefe; border-top: 4px solid #16a34a !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(22, 163, 74, 0.1); color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="bi bi-person-vcard-fill"></i>
                        </div>
                        <span style="font-size: 1.8rem; font-weight: 800; color: #e2e8f0; line-height: 1;">01</span>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">{{ $settings['raport_langkah_1_judul'] ?? 'Siapkan NISN & NIK Siswa' }}</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">
                        {{ $settings['raport_langkah_1_desc'] ?? 'Pastikan Anda mengetahui Nomor Induk Siswa Nasional (NISN) dan Nomor Induk Kependudukan (NIK) siswa yang terdaftar resmi.' }}
                    </p>
                </div>
            </div>

            {{-- LANGKAH 2 --}}
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 position-relative" style="background: #fdfefe; border-top: 4px solid #0d5c3a !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(13, 92, 58, 0.1); color: #0d5c3a; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                        <span style="font-size: 1.8rem; font-weight: 800; color: #e2e8f0; line-height: 1;">02</span>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">{{ $settings['raport_langkah_2_judul'] ?? 'Klik Tombol Login Siswa' }}</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">
                        {{ $settings['raport_langkah_2_desc'] ?? 'Buka halaman login siswa. Masukkan NISN pada kolom ID Pengguna dan NIK pada kolom Kata Sandi (Password).' }}
                    </p>
                </div>
            </div>

            {{-- LANGKAH 3 --}}
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 position-relative" style="background: #fdfefe; border-top: 4px solid #059669 !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(5, 150, 105, 0.1); color: #059669; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="bi bi-calendar3-range-fill"></i>
                        </div>
                        <span style="font-size: 1.8rem; font-weight: 800; color: #e2e8f0; line-height: 1;">03</span>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">{{ $settings['raport_langkah_3_judul'] ?? 'Masuk ke Portal E-Raport' }}</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">
                        {{ $settings['raport_langkah_3_desc'] ?? 'Setelah berhasil login, Anda akan diarahkan ke Portal Raport Siswa yang menampilkan biodata siswa dan daftar riwayat raport.' }}
                    </p>
                </div>
            </div>

            {{-- LANGKAH 4 --}}
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 position-relative" style="background: #fdfefe; border-top: 4px solid #10b981 !important; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="bi bi-file-earmark-arrow-down-fill"></i>
                        </div>
                        <span style="font-size: 1.8rem; font-weight: 800; color: #e2e8f0; line-height: 1;">04</span>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">{{ $settings['raport_langkah_4_judul'] ?? 'Pratinjau & Unduh Dokumen PDF' }}</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">
                        {{ $settings['raport_langkah_4_desc'] ?? 'Pilih semester yang diinginkan, klik "Download PDF" untuk menyimpan file raport atau klik "Pratinjau" untuk membaca langsung.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- BUTTON PROMINEN DI BAWAH LANGKAH TUTORIAL --}}
        <div class="text-center">
            @if($isSiswa)
                <a href="{{ route('siswa.raport.index') }}" class="btn btn-success btn-lg fw-bold px-5 py-3 rounded-pill shadow-sm">
                    <i class="bi bi-folder-check me-2"></i> Buka Portal Raport Saya
                </a>
            @else
                <a href="{{ route('login.index') }}" class="btn btn-success btn-lg fw-bold px-5 py-3 rounded-pill shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Mulai Download Raport Sekarang
                </a>
            @endif
        </div>
    </div>
</section>

{{-- ================= SECTION SYARAT & FAQ ================= --}}
<section class="py-5 bg-light">
    <div class="container py-3">
        <div class="row g-4">
            {{-- KOLOM KIRI: SYARAT & KETENTUAN --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="background: #ffffff;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(13, 92, 58, 0.1); color: #0d5c3a; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                            <i class="bi bi-clipboard-check-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-0 text-dark">Ketentuan Pengunduhan</h4>
                    </div>
                    <p class="text-muted small mb-4">
                        Harap memperhatikan beberapa ketentuan berikut sebelum mengunduh berkas raport:
                    </p>

                    @php
                        $syaratList = explode("\n", $settings['raport_syarat'] ?? '');
                    @endphp
                    <div class="d-flex flex-column gap-3 mb-4">
                        @foreach($syaratList as $s)
                            @if(trim($s))
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success flex-shrink-0 mt-1"></i>
                                <span class="small text-secondary">{{ trim(preg_replace('/^\d+\.\s*/', '', $s)) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- BOX BANTUAN TATA USAHA --}}
                    <div class="mt-auto p-3 rounded-3" style="background: rgba(13, 92, 58, 0.05); border: 1px dashed rgba(13, 92, 58, 0.25);">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-headset fs-2 text-success"></i>
                            <div>
                                <div class="fw-bold small text-dark">{{ $settings['raport_kontak_nama'] ?? 'Layanan Tata Usaha & Bantuan' }}</div>
                                <div class="text-muted" style="font-size: 0.78rem;">Ada kendala login atau raport belum terbit? Hubungi helpdesk kami.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FAQ (PERTANYAAN UMUM) --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="background: #ffffff;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(22, 163, 74, 0.1); color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                            <i class="bi bi-question-circle-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-0 text-dark">Pertanyaan yang Sering Diajukan (FAQ)</h4>
                    </div>
                    <p class="text-muted small mb-4">
                        Jawaban cepat seputar kendala login, format dokumen, dan kebijakan raport digital.
                    </p>

                    <div class="accordion accordion-flush" id="accordionRaportFaq">
                        {{-- FAQ 1 --}}
                        <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqHead1">
                                <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                                    {{ $settings['raport_faq_1_q'] ?? 'Siapa saja yang berhak mengakses dan mengunduh raport digital?' }}
                                </button>
                            </h2>
                            <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#accordionRaportFaq">
                                <div class="accordion-body text-muted small" style="line-height: 1.6;">
                                    {{ $settings['raport_faq_1_a'] ?? 'Siswa yang berstatus aktif dan wali murid yang memiliki kredensial NISN serta NIK yang terdaftar resmi di basis data sekolah.' }}
                                </div>
                            </div>
                        </div>

                        {{-- FAQ 2 --}}
                        <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqHead2">
                                <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                                    {{ $settings['raport_faq_2_q'] ?? 'Bagaimana jika lupa NISN atau NIK siswa?' }}
                                </button>
                            </h2>
                            <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#accordionRaportFaq">
                                <div class="accordion-body text-muted small" style="line-height: 1.6;">
                                    {{ $settings['raport_faq_2_a'] ?? 'Silakan periksa Kartu Keluarga (KK) atau buku rapor semester sebelumnya. Anda juga dapat menghubungi Admin Tata Usaha atau Wali Kelas masing-masing.' }}
                                </div>
                            </div>
                        </div>

                        {{-- FAQ 3 --}}
                        <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqHead3">
                                <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                                    {{ $settings['raport_faq_3_q'] ?? 'Apakah raport digital ini resmi dan bisa dicetak sendiri?' }}
                                </button>
                            </h2>
                            <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#accordionRaportFaq">
                                <div class="accordion-body text-muted small" style="line-height: 1.6;">
                                    {{ $settings['raport_faq_3_a'] ?? 'Ya, dokumen berformat PDF standar A4 resmi yang dapat dicetak sewaktu-waktu untuk keperluan beasiswa, arsip, atau pendaftaran jenjang berikutnya.' }}
                                </div>
                            </div>
                        </div>

                        {{-- FAQ 4 --}}
                        <div class="accordion-item border rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqHead4">
                                <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4">
                                    {{ $settings['raport_faq_4_q'] ?? 'Mengapa raport belum muncul atau belum bisa didownload?' }}
                                </button>
                            </h2>
                            <div id="faqCollapse4" class="accordion-collapse collapse" data-bs-parent="#accordionRaportFaq">
                                <div class="accordion-body text-muted small" style="line-height: 1.6;">
                                    {{ $settings['raport_faq_4_a'] ?? 'Raport hanya dapat diunduh jika statusnya telah "Diterbitkan" (Published) oleh pihak sekolah sesuai dengan jadwal rilis resmi.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= CTA BOX BAWAH ================= --}}
<section class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #0d5c3a 0%, #15803d 100%);">
    <div class="container text-center py-3">
        <h3 class="fw-bold mb-3">Siap Mengakses Raport Digital Anda?</h3>
        <p class="text-white-50 mx-auto mb-4" style="max-width: 600px;">
            Akses dokumen hasil evaluasi belajar siswa kapan pun dan di mana pun melalui portal digital SMP Sains Al-Qur'an Klakah.
        </p>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            @if($isSiswa)
                <a href="{{ route('siswa.raport.index') }}" class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-pill shadow">
                    <i class="bi bi-folder-check me-2"></i> Buka Portal Raport Saya
                </a>
            @else
                <a href="{{ route('login.index') }}" class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-pill shadow">
                    <i class="bi bi-box-arrow-in-right me-2"></i> {{ $settings['raport_btn_login_text'] ?? 'Login Siswa & Unduh Raport' }}
                </a>
            @endif

            @if($cleanWa)
            <a href="https://wa.me/{{ $cleanWa }}?text=Assalamu%27alaikum%20Admin%2C%20saya%20ingin%20bertanya%20mengenai%20raport%20digital." 
               target="_blank" 
               class="btn btn-outline-light btn-lg fw-semibold px-4 py-3 rounded-pill">
                <i class="bi bi-whatsapp me-2"></i> Hubungi Helpdesk
            </a>
            @endif
        </div>
    </div>
</section>

@endsection
