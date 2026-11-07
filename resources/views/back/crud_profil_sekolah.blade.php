@extends('layouts.admin.app')

@section('title', 'Profil Sekolah')
@section('page-title', 'Profil Sekolah')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Pengaturan</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Profil Sekolah</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Profil & Identitas Sekolah</h1>
            <p class="page-subtitle">Kelola data resmi sekolah, kontak, visi misi, dan informasi pimpinan</p>
        </div>
        <div>
            <button type="button" class="ab ab-primary" onclick="document.getElementById('formProfil').submit()">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success d-flex align-items-center mb-3">
    <i class="bi bi-check-circle-fill" style="font-size: 1.1rem; margin-right: 8px;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger d-flex align-items-center mb-3">
    <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.1rem; margin-right: 8px;"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

@if(isset($errors) && $errors->any())
<div class="alert alert-danger mb-3">
    <div class="d-flex align-items-center mb-1">
        <i class="bi bi-exclamation-circle-fill" style="font-size: 1.1rem; margin-right: 8px;"></i>
        <strong>Terdapat kesalahan pada isian form:</strong>
    </div>
    <ul class="mb-0" style="padding-left: 24px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form id="formProfil" action="{{ route('admin.profil-sekolah.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- CARD 1: IDENTITAS SEKOLAH --}}
    <div class="ac mb-4">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-mortarboard-fill"></i> Identitas Pokok Sekolah
            </span>
        </div>
        <div class="ac-body">
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="af-label">Nama Sekolah <span class="req">*</span></label>
                    <input type="text" name="nama_sekolah" class="af-input" value="{{ old('nama_sekolah', $profil->nama_sekolah) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="af-label">NPSN</label>
                    <input type="text" name="npsn" class="af-input" value="{{ old('npsn', $profil->npsn) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="af-label">Akreditasi</label>
                    <input type="text" name="akreditasi" class="af-input" value="{{ old('akreditasi', $profil->akreditasi) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="af-label">Tagline / Semboyan</label>
                    <input type="text" name="tagline" class="af-input" value="{{ old('tagline', $profil->tagline) }}" placeholder="e.g. Unggul dalam Sains, Kokoh dalam Al-Qur'an">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="af-label">Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" class="af-input" value="{{ old('tahun_berdiri', $profil->tahun_berdiri) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="af-label">Jumlah Siswa</label>
                    <input type="number" name="jumlah_siswa" class="af-input" value="{{ old('jumlah_siswa', $profil->jumlah_siswa) }}">
                    <p class="af-hint">Otomatis sinkron dengan Manajemen Siswa ({{ \App\Models\Siswa::where('status', 'aktif')->count() }} siswa aktif).</p>
                </div>
                <div class="col-12 mb-3">
                    <label class="af-label">Deskripsi Singkat Sekolah</label>
                    <textarea name="deskripsi" rows="3" class="af-textarea">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="af-label">Sejarah Sekolah</label>
                    <textarea name="sejarah" rows="4" class="af-textarea">{{ old('sejarah', $profil->sejarah) }}</textarea>
                </div>
                <div class="col-12 mb-2">
                    <label class="af-label">Meta Description (SEO Google)</label>
                    <textarea name="meta_description" rows="2" class="af-textarea" maxlength="160">{{ old('meta_description', $profil->meta_description) }}</textarea>
                    <p class="af-hint">Maksimal 160 karakter untuk pratinjau mesin pencari</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2: VISI & MISI --}}
    <div class="ac mb-4">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-compass-fill"></i> Visi & Misi Sekolah
            </span>
        </div>
        <div class="ac-body">
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="af-label">Visi Sekolah</label>
                    <textarea name="visi" rows="5" class="af-textarea">{{ old('visi', $profil->visi) }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="af-label">Misi Sekolah</label>
                    <textarea name="misi" rows="5" class="af-textarea">{{ old('misi', $profil->misi) }}</textarea>
                    <p class="af-hint">Gunakan enter / baris baru untuk memisahkan setiap poin misi</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 3: SAMBUTAN KEPALA SEKOLAH --}}
    @php
        $kepsekData = \App\Models\Tenaga_pendidik::where('jabatan', 'like', '%kepala%sekolah%')->first();
    @endphp
    <div class="ac mb-4">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-chat-quote-fill"></i> Sambutan Kepala Sekolah
            </span>
        </div>
        <div class="ac-body">
            {{-- Info Banner Kepala Sekolah dari Guru & Staf --}}
            <div class="p-3 mb-3 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: rgba(13, 92, 58, 0.06); border: 1px solid rgba(13, 92, 58, 0.2);">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; background: #ffffff; border: 2px solid #0d5c3a; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        @if($kepsekData && $kepsekData->foto)
                            <img src="{{ image_url($kepsekData->foto) }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <i class="bi bi-person-fill fs-3 text-secondary"></i>
                        @endif
                    </div>
                    <div>
                        <div class="small text-muted" style="font-size: 0.78rem;">Kepala Sekolah saat ini (diatur di menu Guru & Staf):</div>
                        <div class="fw-bold text-dark fs-6">{{ $kepsekData ? $kepsekData->nama : 'Belum diatur' }}</div>
                        @if($kepsekData && $kepsekData->NIP)
                            <div class="small text-muted" style="font-size: 0.75rem;">NIP: {{ $kepsekData->NIP }}</div>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.tenaga-pendidik.index', ['jabatan' => 'Kepala Sekolah']) }}" class="ab ab-sm ab-outline" style="font-size: 0.8rem; border-color: #0d5c3a; color: #0d5c3a;">
                    <i class="bi bi-person-gear"></i> Kelola di Guru & Staf
                </a>
            </div>

            <div class="row g-3">
                <div class="col-12 mb-2">
                    <label class="af-label">Teks Kata Sambutan Kepala Sekolah <span class="req">*</span></label>
                    <textarea name="sambutan_kepsek" rows="5" class="af-textarea" placeholder="Tuliskan kata sambutan kepala sekolah untuk ditampilkan di halaman depan dan profil sekolah..." required>{{ old('sambutan_kepsek', $profil->sambutan_kepsek) }}</textarea>
                    <small class="text-muted">Teks ini akan otomatis ditampilkan di kartu sambutan landing page utama dan halaman Profil Sekolah.</small>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 4: KONTAK & MEDIA SOSIAL --}}
    <div class="ac mb-4">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-telephone-fill"></i> Kontak & Media Sosial
            </span>
        </div>
        <div class="ac-body">
            <div class="row g-3">
                <div class="col-12 mb-3">
                    <label class="af-label">Alamat Lengkap Sekolah</label>
                    <input type="text" name="alamat" class="af-input" value="{{ old('alamat', $profil->alamat) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">Nomor Telepon Kantor</label>
                    <input type="text" name="telepon" class="af-input" value="{{ old('telepon', $profil->telepon) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">Email Resmi</label>
                    <input type="email" name="email" class="af-input" value="{{ old('email', $profil->email) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">WhatsApp (Nomor tanpa +)</label>
                    <input type="text" name="whatsapp" class="af-input" value="{{ old('whatsapp', $profil->whatsapp) }}" placeholder="6287612346453">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">URL Instagram</label>
                    <input type="url" name="instagram" class="af-input" value="{{ old('instagram', $profil->instagram) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">URL YouTube Channel</label>
                    <input type="url" name="youtube" class="af-input" value="{{ old('youtube', $profil->youtube) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">URL Facebook Page</label>
                    <input type="url" name="facebook" class="af-input" value="{{ old('facebook', $profil->facebook) }}">
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 5: LOGO, FOTO & PETA --}}
    <div class="ac mb-4">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-images"></i> Logo, Banner & Lokasi Peta
            </span>
        </div>
        <div class="ac-body">
            <div class="row g-3">
                <div class="col-md-4 mb-3">
                    <label class="af-label">Logo Sekolah</label>
                    @if($profil->logo)
                        <div class="mb-2"><img src="{{ image_url($profil->logo) }}" height="50" class="rounded"></div>
                    @endif
                    <input type="file" name="logo" class="af-file" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">Foto Gedung Utama Sekolah</label>
                    @if($profil->gambar)
                        <div class="mb-2"><img src="{{ image_url($profil->gambar) }}" height="50" class="rounded"></div>
                    @endif
                    <input type="file" name="gambar" class="af-file" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">Favicon Tab Browser</label>
                    @if($profil->favicon)
                        <div class="mb-2"><img src="{{ image_url($profil->favicon) }}" height="30"></div>
                    @endif
                    <input type="file" name="favicon" class="af-file" accept="image/*">
                </div>
                <div class="col-12 mb-2">
                    <label class="af-label">Embed URL Google Maps (src iframe saja)</label>
                    <textarea name="maps_embed" rows="2" class="af-textarea">{{ old('maps_embed', $profil->maps_embed) }}</textarea>
                    <p class="af-hint">Salin hanya URL pada atribut <code>src="..."</code> dari kode embed Google Maps</p>
                </div>
            </div>
        </div>
    </div>

    {{-- SUBMIT BAR --}}
    <div class="d-flex justify-content-end mb-5">
        <button type="submit" class="ab ab-primary ab-lg" style="gap: 8px;">
            <i class="bi bi-check-lg" style="font-size: 1.2rem;"></i> Simpan Semua Perubahan
        </button>
    </div>
</form>

@endsection
