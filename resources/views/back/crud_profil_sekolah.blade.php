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

@if($errors->any())
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

    {{-- CARD 3: KEPALA SEKOLAH --}}
    <div class="ac mb-4">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-person-badge-fill"></i> Kepala Sekolah & Sambutan
            </span>
        </div>
        <div class="ac-body">
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="af-label">Nama Kepala Sekolah</label>
                    <input type="text" name="nama_kepsek" class="af-input" value="{{ old('nama_kepsek', $profil->nama_kepsek) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="af-label">Foto Kepala Sekolah</label>
                    @if($profil->foto_kepsek)
                        <div class="d-flex align-items-center gap-2 mb-2" style="background: #f9fafb; padding: 6px 12px; border-radius: 8px; border: 1px solid var(--border);">
                            <img src="{{ asset('storage/'.$profil->foto_kepsek) }}" height="40" class="rounded">
                            <span style="font-size: 0.78rem; color: var(--text-muted);">Foto saat ini terpasang</span>
                        </div>
                    @endif
                    <input type="file" name="foto_kepsek" class="af-file" accept="image/*">
                </div>
                <div class="col-12 mb-2">
                    <label class="af-label">Kata Sambutan Kepala Sekolah</label>
                    <textarea name="sambutan_kepsek" rows="4" class="af-textarea">{{ old('sambutan_kepsek', $profil->sambutan_kepsek) }}</textarea>
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
                        <div class="mb-2"><img src="{{ asset('storage/'.$profil->logo) }}" height="50" class="rounded"></div>
                    @endif
                    <input type="file" name="logo" class="af-file" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">Foto Gedung Utama Sekolah</label>
                    @if($profil->gambar)
                        <div class="mb-2"><img src="{{ asset('storage/'.$profil->gambar) }}" height="50" class="rounded"></div>
                    @endif
                    <input type="file" name="gambar" class="af-file" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="af-label">Favicon Tab Browser</label>
                    @if($profil->favicon)
                        <div class="mb-2"><img src="{{ asset('storage/'.$profil->favicon) }}" height="30"></div>
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
