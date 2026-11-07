@extends('layouts.main')

@section('title', 'Layanan Pengaduan & Aspirasi')

@section('content')

@php
    $profil = \App\Models\ProfilSekolah::first();
    $waSekolah = $profil->whatsapp ?? '6282233671882';
    $cleanWa = preg_replace('/[^0-9]/', '', $waSekolah);
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
@endphp

{{-- ================= HERO BANNER ================= --}}
<section class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #0d5c3a 0%, #15803d 50%, #166534 100%); overflow: hidden;">
    {{-- Background Pattern --}}
    <div style="position: absolute; top: -60px; right: -60px; width: 340px; height: 340px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -80px; left: -80px; width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 70%); pointer-events: none;"></div>

    <div class="container py-4 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 text-center text-lg-start">
                <span class="badge px-3 py-2 rounded-pill mb-3 d-inline-flex align-items-center" style="background: rgba(255, 255, 255, 0.15); color: #ffffff; font-size: 0.85rem; font-weight: 600; border: 1px solid rgba(255,255,255,0.25);">
                    <i class="bi bi-megaphone-fill text-warning me-2 fs-6"></i>
                    <span>Layanan Aspirasi & Pengaduan Masyarakat</span>
                </span>
                <h1 class="display-6 fw-bold mb-3 text-white" style="letter-spacing: -0.5px; line-height: 1.25;">
                    Layanan Pengaduan & Aspirasi Sekolah
                </h1>
                <p class="lead text-white-50 mb-4" style="font-size: 1.05rem; max-width: 680px;">
                    Sampaikan masukan, saran, atau kendala Anda demi kemajuan pendidikan di SMP Sains Al-Qur'an Klakah. Kami berkomitmen mendengar setiap aspirasi secara transparan dan bertanggung jawab.
                </p>

                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill text-white" style="background: rgba(255, 255, 255, 0.12); font-size: 0.82rem; border: 1px solid rgba(255,255,255,0.18);">
                        <i class="bi bi-shield-check text-warning"></i>
                        <span>Privasi Terjaga</span>
                    </div>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill text-white" style="background: rgba(255, 255, 255, 0.12); font-size: 0.82rem; border: 1px solid rgba(255,255,255,0.18);">
                        <i class="bi bi-clock-history text-warning"></i>
                        <span>Respon Cepat</span>
                    </div>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill text-white" style="background: rgba(255, 255, 255, 0.12); font-size: 0.82rem; border: 1px solid rgba(255,255,255,0.18);">
                        <i class="bi bi-people-fill text-warning"></i>
                        <span>Ditinjau Manajemen Sekolah</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-none d-lg-block text-center">
                <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                    <div class="mb-3" style="width: 72px; height: 72px; margin: 0 auto; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chat-heart-fill text-warning fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-white">Suara Anda Berarti</h5>
                    <p class="text-white-50 small mb-0">Setiap kritik membangun dan saran menjadi langkah nyata kemajuan kita bersama.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= CONTENT FORM ================= --}}
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container py-2">
        <div class="row g-4 justify-content-center">
            
            {{-- KOLOM KIRI: FORM PENGADUAN --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(22, 101, 52, 0.1); color: #166534; font-size: 1.3rem;">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">Formulir Pengaduan & Saran</h4>
                            <p class="text-muted small mb-0">Lengkapi formulir di bawah ini dengan informasi yang valid.</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center gap-3 rounded-3 mb-4 border-0 shadow-sm" style="background: #ecfdf5; color: #065f46;">
                            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                            <div>
                                <strong class="d-block">Terima Kasih!</strong>
                                <span class="small">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger rounded-3 mb-4 border-0 shadow-sm" style="background: #fef2f2; color: #991b1b;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                                <strong>Mohon periksa kesalahan input berikut:</strong>
                            </div>
                            <ul class="mb-0 small ps-3">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pengaduan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" name="nama" class="form-control border-start-0 ps-0"
                                       placeholder="Masukkan nama lengkap Anda"
                                       value="{{ old('nama') }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">Alamat Email <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0"
                                           placeholder="nama@email.com"
                                           value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">No. WhatsApp / HP <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="no_hp" class="form-control border-start-0 ps-0"
                                           placeholder="Contoh: 081234567890"
                                           value="{{ old('no_hp') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Topik / Judul Pengaduan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-card-heading"></i></span>
                                <input type="text" name="judul" class="form-control border-start-0 ps-0"
                                       placeholder="Contoh: Masukan Fasilitas Kelas / Layanan Guru"
                                       value="{{ old('judul') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small">Isi Pesan Pengaduan / Aspirasi <span class="text-danger">*</span></label>
                            <textarea name="isi" rows="5" class="form-control" 
                                      placeholder="Tuliskan detail aspirasi, kritik, atau saran Anda secara santun, jelas, dan konstruktif..." 
                                      required>{{ old('isi') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center gap-2" style="background: #166534; border-color: #166534; font-size: 1rem;">
                            <i class="bi bi-send-fill"></i>
                            <span>Kirim Pengaduan Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN: ALUR & HELPDESK CEPAT --}}
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-4">
                    
                    {{-- KARTU ALUR --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-arrow-repeat text-success"></i>
                            <span>Alur Penanganan Laporan</span>
                        </h5>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    1
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 small text-dark">Kirim Pengaduan</h6>
                                    <p class="text-muted small mb-0">Isi formulir pengaduan dengan rincian yang lengkap dan jelas.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    2
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 small text-dark">Verifikasi & Penelaahan</h6>
                                    <p class="text-muted small mb-0">Tim manajemen sekolah akan menelaah substansi pesan yang masuk.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                    3
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 small text-dark">Tindak Lanjut & Solusi</h6>
                                    <p class="text-muted small mb-0">Langkah penyelesaian diambil secara terukur demi evaluasi berkelanjutan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU KONTAK LANGSUNG / HELPDESK --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #14532d 0%, #166534 100%);">
                        <h5 class="fw-bold mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-headset text-warning"></i>
                            <span>Butuh Bantuan Langsung?</span>
                        </h5>
                        <p class="text-white-50 small mb-3">
                            Jika memiliki kendala mendesak atau pertanyaan seputar sekolah, Anda juga dapat menghubungi layanan admin kami:
                        </p>
                        
                        <div class="d-flex flex-column gap-2 mb-3">
                            <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Admin%20SMP%20Sains%20Al-Qur'an%20Klakah,%20saya%20ingin%20menyampaikan%20aspirasi/pengaduan" 
                               target="_blank" 
                               class="btn btn-warning fw-bold rounded-pill text-dark d-flex align-items-center justify-content-center gap-2 py-2">
                                <i class="bi bi-whatsapp fs-5"></i>
                                <span>Hubungi via WhatsApp</span>
                            </a>
                            
                            @if($profil && $profil->email)
                            <a href="mailto:{{ $profil->email }}" 
                               class="btn btn-outline-light rounded-pill d-flex align-items-center justify-content-center gap-2 py-2 small">
                                <i class="bi bi-envelope-fill"></i>
                                <span>{{ $profil->email }}</span>
                            </a>
                            @endif
                        </div>

                        <div class="pt-2 border-top border-white-50 small text-white-50 text-center" style="font-size: 0.75rem;">
                            <i class="bi bi-shield-lock me-1"></i> Identitas dan pesan Anda diperlakukan dengan penuh kerahasiaan.
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
