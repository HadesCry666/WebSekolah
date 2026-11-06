@extends('layouts.admin.app')

@section('title', 'Kelola Kurikulum')
@section('page-title', 'Kurikulum & Pembelajaran')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Akademik</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Kurikulum</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Kurikulum & Pembelajaran</h1>
            <p class="page-subtitle">Kelola pilar kurikulum, struktur mata pelajaran, dan profil capaian lulusan</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('kurikulum.index') }}" target="_blank" class="ab ab-secondary">
                <i class="bi bi-eye"></i> Lihat di Web
            </a>
            <button type="button" class="ab ab-primary" onclick="openAddModal()">
                <i class="bi bi-plus-lg"></i> Tambah Item
            </button>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success d-flex align-items-center mb-3">
    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(isset($errors) && $errors->any())
<div class="alert alert-danger mb-3">
    <div class="d-flex align-items-center mb-1">
        <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
        <strong>Terdapat kesalahan pada isian form:</strong>
    </div>
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Stat Cards --}}
<div class="stat-grid mb-4" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-label">Total Item Kurikulum</span>
            <div class="stat-icon-wrap" style="background: rgba(13, 92, 58, 0.1); color: #0d5c3a;">
                <i class="bi bi-book-half"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-sub">Item aktif & terkelola</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-label">Pilar Kurikulum</span>
            <div class="stat-icon-wrap" style="background: rgba(22, 163, 74, 0.1); color: #16a34a;">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['pilar'] }}</div>
        <div class="stat-sub">Fondasi pendidikan</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-label">Mata Pelajaran</span>
            <div class="stat-icon-wrap" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                <i class="bi bi-journal-text"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['mapel'] }}</div>
        <div class="stat-sub">Umum, Islam, & Sains</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-label">Capaian Lulusan</span>
            <div class="stat-icon-wrap" style="background: rgba(217, 119, 6, 0.1); color: #d97706;">
                <i class="bi bi-award-fill"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['capaian'] }}</div>
        <div class="stat-sub">Target profil santri</div>
    </div>
</div>

{{-- Navigation Tabs --}}
<div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-2 flex-wrap">
    <a href="{{ route('admin.kurikulum.index', ['tab' => 'pilar']) }}"
       class="ab {{ $tab == 'pilar' ? 'ab-primary' : 'ab-secondary' }} ab-sm" style="border-radius: 999px;">
        <i class="bi bi-mortarboard"></i> 1. Pilar Kurikulum ({{ $stats['pilar'] }})
    </a>
    <a href="{{ route('admin.kurikulum.index', ['tab' => 'mapel']) }}"
       class="ab {{ $tab == 'mapel' ? 'ab-primary' : 'ab-secondary' }} ab-sm" style="border-radius: 999px;">
        <i class="bi bi-journal-text"></i> 2. Mata Pelajaran ({{ $stats['mapel'] }})
    </a>
    <a href="{{ route('admin.kurikulum.index', ['tab' => 'capaian']) }}"
       class="ab {{ $tab == 'capaian' ? 'ab-primary' : 'ab-secondary' }} ab-sm" style="border-radius: 999px;">
        <i class="bi bi-award"></i> 3. Profil Capaian ({{ $stats['capaian'] }})
    </a>
    <a href="{{ route('admin.kurikulum.index', ['tab' => 'pengantar']) }}"
       class="ab {{ $tab == 'pengantar' ? 'ab-primary' : 'ab-secondary' }} ab-sm" style="border-radius: 999px;">
        <i class="bi bi-sliders"></i> 4. Header & Pengantar
    </a>
</div>

{{-- ================= TAB 1: PILAR KURIKULUM ================= --}}
@if($tab == 'pilar')
<div class="ac mb-4">
    <div class="ac-header d-flex justify-content-between align-items-center">
        <span class="ac-title">
            <i class="bi bi-mortarboard-fill"></i> Daftar Pilar Kurikulum Terintegrasi
        </span>
        <button type="button" class="ab ab-primary ab-sm" onclick="openAddModal('pilar')">
            <i class="bi bi-plus-lg"></i> Tambah Pilar
        </button>
    </div>
    <div class="ac-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px; text-align: center;">Urutan</th>
                        <th>Pilar & Ikon</th>
                        <th>Deskripsi</th>
                        <th>Poin-Poin Utama</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 130px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pilars as $p)
                    <tr>
                        <td class="text-center fw-bold">{{ $p->urutan }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(13, 92, 58, 0.1); color: #0d5c3a; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                    <i class="bi {{ $p->ikon ?: 'bi-book' }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $p->judul }}</div>
                                    <small class="text-muted">{{ $p->ikon }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="max-width: 280px;">
                            <div class="small text-muted text-truncate-2">{{ $p->deskripsi }}</div>
                        </td>
                        <td>
                            <ul class="mb-0 ps-3 small text-secondary">
                                @foreach($p->poin_list as $point)
                                    <li>{{ $point }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.kurikulum.toggle', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="badge border-0 {{ $p->is_active ? 'bg-success' : 'bg-secondary' }}" style="cursor: pointer;" title="Klik untuk ubah status">
                                    {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="ab ab-sm ab-outline" onclick='openEditModal(@json($p))' title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="ab ab-sm ab-danger" onclick="confirmDelete('{{ route('admin.kurikulum.destroy', $p->id) }}', '{{ $p->judul }}')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data pilar kurikulum.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ================= TAB 2: MATA PELAJARAN ================= --}}
@if($tab == 'mapel')
<div class="ac mb-4">
    <div class="ac-header d-flex justify-content-between align-items-center">
        <span class="ac-title">
            <i class="bi bi-journal-text"></i> Struktur Kelompok Mata Pelajaran
        </span>
        <button type="button" class="ab ab-primary ab-sm" onclick="openAddModal('mapel')">
            <i class="bi bi-plus-lg"></i> Tambah Mata Pelajaran
        </button>
    </div>
    <div class="ac-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px; text-align: center;">Urutan</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelompok / Kategori</th>
                        <th>Keterangan / Fokus</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 130px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapels as $m)
                    <tr>
                        <td class="text-center fw-bold">{{ $m->urutan }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(13, 92, 58, 0.1); color: #0d5c3a; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                    <i class="bi {{ $m->ikon ?: 'bi-journal-check' }}"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $m->judul }}</span>
                            </div>
                        </td>
                        <td>
                            @if($m->kategori == 'umum')
                                <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1 rounded">Muatan Nasional</span>
                            @elseif($m->kategori == 'islam')
                                <span class="badge bg-success-subtle text-success fw-semibold px-2 py-1 rounded">Keislaman & Tahfidz</span>
                            @elseif($m->kategori == 'sains')
                                <span class="badge bg-info-subtle text-info fw-semibold px-2 py-1 rounded">Sains & Terapan</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary fw-semibold px-2 py-1 rounded">{{ ucfirst($m->kategori) }}</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $m->deskripsi ?: '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.kurikulum.toggle', $m->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="badge border-0 {{ $m->is_active ? 'bg-success' : 'bg-secondary' }}" style="cursor: pointer;">
                                    {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="ab ab-sm ab-outline" onclick='openEditModal(@json($m))' title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="ab ab-sm ab-danger" onclick="confirmDelete('{{ route('admin.kurikulum.destroy', $m->id) }}', '{{ $m->judul }}')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data mata pelajaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ================= TAB 3: PROFIL CAPAIAN LULUSAN ================= --}}
@if($tab == 'capaian')
<div class="ac mb-4">
    <div class="ac-header d-flex justify-content-between align-items-center">
        <span class="ac-title">
            <i class="bi bi-award-fill"></i> Profil Capaian Lulusan Santri
        </span>
        <button type="button" class="ab ab-primary ab-sm" onclick="openAddModal('capaian')">
            <i class="bi bi-plus-lg"></i> Tambah Capaian
        </button>
    </div>
    <div class="ac-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px; text-align: center;">Urutan</th>
                        <th>Target Capaian</th>
                        <th>Keterangan / Kompetensi</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 130px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($capaians as $c)
                    <tr>
                        <td class="text-center fw-bold">{{ $c->urutan }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(217, 119, 6, 0.1); color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.15rem;">
                                    <i class="bi {{ $c->ikon ?: 'bi-award' }}"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $c->judul }}</span>
                            </div>
                        </td>
                        <td class="small text-muted">{{ $c->deskripsi ?: '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.kurikulum.toggle', $c->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="badge border-0 {{ $c->is_active ? 'bg-success' : 'bg-secondary' }}" style="cursor: pointer;">
                                    {{ $c->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="ab ab-sm ab-outline" onclick='openEditModal(@json($c))' title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="ab ab-sm ab-danger" onclick="confirmDelete('{{ route('admin.kurikulum.destroy', $c->id) }}', '{{ $c->judul }}')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data profil capaian lulusan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ================= TAB 4: HEADER & PENGANTAR ================= --}}
@if($tab == 'pengantar')
<div class="ac mb-4">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-sliders"></i> Pengaturan Header & Pengantar Halaman Kurikulum
        </span>
    </div>
    <div class="ac-body">
        <form action="{{ route('admin.kurikulum.update-pengantar') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="af-label">Teks Badge / Subtitle Kecil <span class="req">*</span></label>
                    <input type="text" name="poin_poin" class="af-input" value="{{ old('poin_poin', $pengantar->poin_poin ?? 'Sistem Pendidikan Terpadu') }}" required>
                    <small class="text-muted">Tampil di badge bulat atas judul</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="af-label">Ikon Badge</label>
                    <input type="text" name="ikon" class="af-input" value="{{ old('ikon', $pengantar->ikon ?? 'bi-book-half') }}">
                    <small class="text-muted">Nama class Bootstrap Icon (contoh: <code>bi-book-half</code>)</small>
                </div>
                <div class="col-12 mb-3">
                    <label class="af-label">Judul Utama Halaman <span class="req">*</span></label>
                    <input type="text" name="judul" class="af-input" value="{{ old('judul', $pengantar->judul ?? 'Kurikulum & Pembelajaran') }}" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="af-label">Deskripsi Pengantar Singkat <span class="req">*</span></label>
                    <textarea name="deskripsi" rows="4" class="af-textarea" required>{{ old('deskripsi', $pengantar->deskripsi ?? "SMP Sains Al-Qur'an Klakah menerapkan kurikulum terintegrasi yang mengharmoniskan standar Kurikulum Merdeka dengan pendalaman Sains Modern Berbasis Riset serta keagungan Tahfidz Al-Qur'an.") }}</textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-save"></i> Simpan Pengantar
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.kurikulum.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="addModalTitle">Tambah Item Kurikulum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="af-label">Tipe Item <span class="req">*</span></label>
                            <select name="tipe" id="add_tipe" class="af-select" onchange="toggleFormFields('add')" required>
                                <option value="pilar" {{ $tab == 'pilar' ? 'selected' : '' }}>Pilar Kurikulum</option>
                                <option value="mapel" {{ $tab == 'mapel' ? 'selected' : '' }}>Mata Pelajaran</option>
                                <option value="capaian" {{ $tab == 'capaian' ? 'selected' : '' }}>Capaian Lulusan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2" id="add_kategori_wrap">
                            <label class="af-label">Kategori / Kelompok</label>
                            <select name="kategori" id="add_kategori" class="af-select">
                                <option value="umum">Muatan Nasional (Umum)</option>
                                <option value="islam">Keislaman & Tahfidz</option>
                                <option value="sains">Sains & Terapan</option>
                            </select>
                        </div>

                        <div class="col-md-8 mb-2">
                            <label class="af-label">Judul / Nama Mata Pelajaran <span class="req">*</span></label>
                            <input type="text" name="judul" class="af-input" placeholder="Contoh: Kurikulum Merdeka / Matematika" required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="af-label">Urutan Tampil</label>
                            <input type="number" name="urutan" class="af-input" value="1" min="0">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="af-label">Ikon (Bootstrap Icon)</label>
                            <input type="text" name="ikon" class="af-input" placeholder="bi-book / bi-calculator / bi-cpu">
                            <small class="text-muted">Cari di <a href="https://icons.getbootstrap.com" target="_blank">icons.getbootstrap.com</a></small>
                        </div>

                        <div class="col-md-6 mb-2 d-flex align-items-center">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="add_is_active" checked>
                                <label class="form-check-label fw-semibold" for="add_is_active">Aktifkan Item Ini</label>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="af-label">Deskripsi / Penjelasan Ringkas</label>
                            <textarea name="deskripsi" rows="3" class="af-textarea" placeholder="Tuliskan deskripsi ringkas..."></textarea>
                        </div>

                        <div class="col-12 mb-2" id="add_poin_wrap">
                            <label class="af-label">Poin-Poin Utama (Pisahkan dengan baris baru/Enter)</label>
                            <textarea name="poin_poin" rows="4" class="af-textarea" placeholder="Poin 1&#10;Poin 2&#10;Poin 3"></textarea>
                            <small class="text-muted">Digunakan khusus untuk pilar kurikulum sebagai bullet point</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="ab ab-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="ab ab-primary"><i class="bi bi-save"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Edit Item Kurikulum</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="af-label">Tipe Item <span class="req">*</span></label>
                            <select name="tipe" id="edit_tipe" class="af-select" onchange="toggleFormFields('edit')" required>
                                <option value="pilar">Pilar Kurikulum</option>
                                <option value="mapel">Mata Pelajaran</option>
                                <option value="capaian">Capaian Lulusan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2" id="edit_kategori_wrap">
                            <label class="af-label">Kategori / Kelompok</label>
                            <select name="kategori" id="edit_kategori" class="af-select">
                                <option value="umum">Muatan Nasional (Umum)</option>
                                <option value="islam">Keislaman & Tahfidz</option>
                                <option value="sains">Sains & Terapan</option>
                            </select>
                        </div>

                        <div class="col-md-8 mb-2">
                            <label class="af-label">Judul / Nama Mata Pelajaran <span class="req">*</span></label>
                            <input type="text" name="judul" id="edit_judul" class="af-input" required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="af-label">Urutan Tampil</label>
                            <input type="number" name="urutan" id="edit_urutan" class="af-input" min="0">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="af-label">Ikon (Bootstrap Icon)</label>
                            <input type="text" name="ikon" id="edit_ikon" class="af-input">
                        </div>

                        <div class="col-md-6 mb-2 d-flex align-items-center">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit_is_active">
                                <label class="form-check-label fw-semibold" for="edit_is_active">Aktifkan Item Ini</label>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="af-label">Deskripsi / Penjelasan Ringkas</label>
                            <textarea name="deskripsi" id="edit_deskripsi" rows="3" class="af-textarea"></textarea>
                        </div>

                        <div class="col-12 mb-2" id="edit_poin_wrap">
                            <label class="af-label">Poin-Poin Utama (Pisahkan dengan baris baru/Enter)</label>
                            <textarea name="poin_poin" id="edit_poin_poin" rows="4" class="af-textarea"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="ab ab-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="ab ab-primary"><i class="bi bi-save"></i> Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL DELETE ================= --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <i class="bi bi-exclamation-triangle text-danger display-4 mb-2 d-block"></i>
                    <h5 class="fw-bold mb-2">Hapus Item Kurikulum?</h5>
                    <p class="text-muted small mb-4" id="deleteItemName">Apakah Anda yakin ingin menghapus data ini?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="ab ab-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="ab ab-danger">Ya, Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFormFields(prefix) {
    const tipe = document.getElementById(prefix + '_tipe').value;
    const kategoriWrap = document.getElementById(prefix + '_kategori_wrap');
    const poinWrap = document.getElementById(prefix + '_poin_wrap');

    if (tipe === 'mapel') {
        kategoriWrap.style.display = 'block';
        poinWrap.style.display = 'none';
    } else if (tipe === 'pilar') {
        kategoriWrap.style.display = 'none';
        poinWrap.style.display = 'block';
    } else {
        kategoriWrap.style.display = 'none';
        poinWrap.style.display = 'none';
    }
}

function openAddModal(defaultType) {
    if (defaultType) {
        document.getElementById('add_tipe').value = defaultType;
    }
    toggleFormFields('add');
    const modal = new bootstrap.Modal(document.getElementById('addModal'));
    modal.show();
}

function openEditModal(item) {
    document.getElementById('editForm').action = "{{ url('admin/kurikulum') }}/" + item.id;
    document.getElementById('edit_tipe').value = item.tipe || 'pilar';
    document.getElementById('edit_kategori').value = item.kategori || 'umum';
    document.getElementById('edit_judul').value = item.judul || '';
    document.getElementById('edit_urutan').value = item.urutan || 0;
    document.getElementById('edit_ikon').value = item.ikon || '';
    document.getElementById('edit_deskripsi').value = item.deskripsi || '';
    document.getElementById('edit_poin_poin').value = item.poin_poin || '';
    document.getElementById('edit_is_active').checked = !!item.is_active;

    toggleFormFields('edit');
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

function confirmDelete(actionUrl, itemName) {
    document.getElementById('deleteForm').action = actionUrl;
    document.getElementById('deleteItemName').innerText = 'Apakah Anda yakin ingin menghapus "' + itemName + '"? Tindakan ini tidak dapat dibatalkan.';
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    toggleFormFields('add');
});
</script>
@endpush

@endsection
