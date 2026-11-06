@extends('layouts.admin.app')

@section('title', 'Manajemen Siswa')
@section('page-title', 'Siswa')

@section('content')

{{-- Breadcrumb --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Manajemen Siswa</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Manajemen Siswa</h1>
            <p class="page-subtitle">Kelola data siswa SMP Sains Al-Qur'an Klakah</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button class="ab ab-secondary" onclick="openModal('importModal')">
                <i class="bi bi-file-earmark-excel"></i> Import Excel
            </button>
            <button class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Siswa
            </button>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <span>{{ session('error') }}</span>
</div>
@endif
@if(session('warning'))
<div class="alert alert-warning">
    <i class="bi bi-exclamation-circle-fill"></i>
    <span>{{ session('warning') }}</span>
</div>
@endif

{{-- STAT CARDS --}}
<div class="stat-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Total Siswa</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['total'] }}</div>
        <span class="stat-card-link">Semua data</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Siswa Aktif</span>
            <div class="stat-card-icon ic-success"><i class="bi bi-person-check-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['aktif'] }}</div>
        <span class="stat-card-link">Status aktif</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Laki-laki</span>
            <div class="stat-card-icon ic-info"><i class="bi bi-gender-male"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['laki'] }}</div>
        <span class="stat-card-link">Siswa putra</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Perempuan</span>
            <div class="stat-card-icon ic-purple"><i class="bi bi-gender-female"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['perempuan'] }}</div>
        <span class="stat-card-link">Siswa putri</span>
    </div>
</div>

{{-- FILTER & SEARCH --}}
<div class="ac" style="margin-bottom: 16px;">
    <div class="ac-body" style="padding: 14px 20px;">
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="d-flex gap-2 flex-wrap align-items-end">
            <div style="flex: 1; min-width: 200px;">
                <label class="af-label" style="margin-bottom: 5px;">Cari Siswa</label>
                <div style="position: relative;">
                    <i class="bi bi-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:0.85rem;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="af-input" placeholder="Nama atau NIS..."
                           style="padding-left: 36px;">
                </div>
            </div>
            <div style="min-width: 130px;">
                <label class="af-label" style="margin-bottom: 5px;">Kelas</label>
                <select name="kelas" class="af-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                    <option value="7A" {{ request('kelas') == '7A' ? 'selected' : '' }}>7A</option>
                    <option value="7B" {{ request('kelas') == '7B' ? 'selected' : '' }}>7B</option>
                    <option value="8A" {{ request('kelas') == '8A' ? 'selected' : '' }}>8A</option>
                    <option value="8B" {{ request('kelas') == '8B' ? 'selected' : '' }}>8B</option>
                    <option value="9A" {{ request('kelas') == '9A' ? 'selected' : '' }}>9A</option>
                    <option value="9B" {{ request('kelas') == '9B' ? 'selected' : '' }}>9B</option>
                </select>
            </div>
            <div style="min-width: 130px;">
                <label class="af-label" style="margin-bottom: 5px;">Status</label>
                <select name="status" class="af-select">
                    <option value="">Semua Status</option>
                    <option value="aktif"  {{ request('status') == 'aktif'  ? 'selected' : '' }}>Aktif</option>
                    <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <div style="min-width: 130px;">
                <label class="af-label" style="margin-bottom: 5px;">Jenis Kelamin</label>
                <select name="jk" class="af-select">
                    <option value="">Semua</option>
                    <option value="L" {{ request('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div style="min-width: 110px;">
                <label class="af-label" style="margin-bottom: 5px;">Tampilkan</label>
                <select name="per_page" class="af-select">
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 baris</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 baris</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                @if(request()->hasAny(['search', 'kelas', 'status', 'jk', 'per_page']))
                    <a href="{{ route('admin.siswa.index') }}" class="ab ab-secondary" title="Reset Filter">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- DATA TABLE --}}
<div class="ac">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-table"></i>
            Daftar Siswa
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $siswa->total() }} data)
            </span>
        </span>
        <div class="d-flex gap-2">
            <span style="font-size: 0.8rem; color: var(--text-muted);">
                Halaman {{ $siswa->currentPage() }} dari {{ $siswa->lastPage() }}
            </span>
        </div>
    </div>
    <div class="ac-body-flush">
        <div class="table-responsive">
            <table class="at">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Siswa</th>
                        <th>NIS / NISN</th>
                        <th>NIK</th>
                        <th>Kelas</th>
                        <th>JK</th>
                        <th>Wali</th>
                        <th>Status</th>
                        <th style="width: 100px; text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $i => $s)
                    <tr>
                        <td style="color: var(--text-muted); font-size: 0.8rem;">
                            {{ $siswa->firstItem() + $i }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                {{-- Avatar --}}
                                <div style="
                                    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
                                    background: {{ $s->jenis_kelamin === 'L' ? 'linear-gradient(135deg,#dbeafe,#93c5fd)' : 'linear-gradient(135deg,#fce7f3,#f9a8d4)' }};
                                    display: flex; align-items: center; justify-content: center;
                                    font-size: 0.85rem; font-weight: 700;
                                    color: {{ $s->jenis_kelamin === 'L' ? '#1d4ed8' : '#be185d' }};
                                    overflow: hidden;
                                ">
                                    @if($s->foto)
                                        <img src="{{ asset('storage/'.$s->foto) }}" style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        {{ strtoupper(substr($s->nama, 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.875rem;">{{ $s->nama }}</div>
                                    @if($s->tempat_lahir && $s->tanggal_lahir)
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                                            {{ $s->tempat_lahir }}, {{ $s->tanggal_lahir->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-family: 'Courier New', monospace; font-size: 0.84rem; font-weight: 600; color: var(--text-primary);">
                                {{ $s->nis }}
                            </div>
                            @if($s->nisn)
                                <div style="font-size: 0.74rem; color: #0284c7; font-weight: 600;">NISN: {{ $s->nisn }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-family: 'Courier New', monospace; font-size: 0.84rem; font-weight: 600; color: #334155;">
                                {{ $s->nik ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($s->kelas)
                                <span class="badge badge-primary" style="font-size: 0.78rem;">{{ $s->kelas }}</span>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $s->jenis_kelamin === 'L' ? 'badge-info' : 'badge-gray' }}"
                                  style="{{ $s->jenis_kelamin === 'P' ? 'background:#fce7f3; color:#be185d;' : '' }}">
                                <i class="bi bi-gender-{{ $s->jenis_kelamin === 'L' ? 'male' : 'female' }}"></i>
                                {{ $s->jenis_kelamin === 'L' ? 'L' : 'P' }}
                            </span>
                        </td>
                        <td>
                            @if($s->nama_wali)
                                <div style="font-size: 0.84rem;">{{ $s->nama_wali }}</div>
                                @if($s->kontak_wali)
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $s->kontak_wali }}</div>
                                @endif
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'aktif'  => 'badge-success',
                                    'alumni' => 'badge-info',
                                    'pindah' => 'badge-warning',
                                    'keluar' => 'badge-danger',
                                ][$s->status] ?? 'badge-gray';
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($s->status) }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-end">
                                <button class="ab ab-sm ab-warning ab-icon"
                                        onclick="openEditModal({{ $s->id }}, {{ json_encode($s) }})"
                                        title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data siswa {{ addslashes($s->nama) }}?')">
                                    @csrf @method('DELETE')
                                    <button class="ab ab-sm ab-danger ab-icon" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 48px 0; color: var(--text-muted);">
                            <i class="bi bi-people" style="font-size: 2.5rem; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                            <div style="font-weight: 600; margin-bottom: 4px;">Belum ada data siswa</div>
                            <div style="font-size: 0.8rem;">Tambah siswa atau import dari Excel</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Modern --}}
        {{ $siswa->links('partials.pagination') }}
    </div>
</div>


{{-- ========= MODAL: TAMBAH SISWA ========= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title"><i class="bi bi-person-plus-fill" style="color:var(--primary);"></i> Tambah Siswa Baru</span>
            <button class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group">
                        <label class="af-label">NIS <span class="req">*</span></label>
                        <input type="text" name="nis" class="af-input" placeholder="e.g. 2024001" required>
                    </div>
                    <div class="af-group">
                        <label class="af-label">NISN (Nomor Induk Siswa Nasional)</label>
                        <input type="text" name="nisn" class="af-input" placeholder="e.g. 0091234567 (10 digit)">
                    </div>
                    <div class="af-group">
                        <label class="af-label">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" class="af-input" placeholder="e.g. 3508123456780001 (16 digit)">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama" class="af-input" placeholder="Nama siswa" required>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Kelas</label>
                        <input type="text" name="kelas" class="af-input" placeholder="e.g. 7A">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Jenis Kelamin <span class="req">*</span></label>
                        <select name="jenis_kelamin" class="af-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="af-input" placeholder="Kota kelahiran">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="af-input">
                    </div>
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Alamat</label>
                        <textarea name="alamat" class="af-textarea" placeholder="Alamat lengkap siswa" rows="2"></textarea>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Nama Wali</label>
                        <input type="text" name="nama_wali" class="af-input" placeholder="Nama orang tua/wali">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Kontak Wali</label>
                        <input type="text" name="kontak_wali" class="af-input" placeholder="No. HP wali">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Status <span class="req">*</span></label>
                        <select name="status" class="af-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="alumni">Alumni</option>
                            <option value="pindah">Pindah</option>
                            <option value="keluar">Keluar</option>
                        </select>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Foto (opsional)</label>
                        <input type="file" name="foto" class="af-file" accept="image/*">
                        <p class="af-hint">Format: jpg, png, webp. Maks 2MB</p>
                    </div>
                </div>
            </div>
            <div class="amodal-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ========= MODAL: EDIT SISWA ========= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title"><i class="bi bi-pencil-fill" style="color:var(--warning);"></i> Edit Data Siswa</span>
            <button class="amodal-close" onclick="closeModal('editModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group">
                        <label class="af-label">NIS <span class="req">*</span></label>
                        <input type="text" name="nis" id="edit_nis" class="af-input" required>
                    </div>
                    <div class="af-group">
                        <label class="af-label">NISN (Nomor Induk Siswa Nasional)</label>
                        <input type="text" name="nisn" id="edit_nisn" class="af-input" placeholder="e.g. 0091234567">
                    </div>
                    <div class="af-group">
                        <label class="af-label">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" id="edit_nik" class="af-input" placeholder="e.g. 3508123456780001">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama" id="edit_nama" class="af-input" required>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Kelas</label>
                        <input type="text" name="kelas" id="edit_kelas" class="af-input">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Jenis Kelamin <span class="req">*</span></label>
                        <select name="jenis_kelamin" id="edit_jk" class="af-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="edit_tl" class="af-input">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="edit_ttl" class="af-input">
                    </div>
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Alamat</label>
                        <textarea name="alamat" id="edit_alamat" class="af-textarea" rows="2"></textarea>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Nama Wali</label>
                        <input type="text" name="nama_wali" id="edit_wali" class="af-input">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Kontak Wali</label>
                        <input type="text" name="kontak_wali" id="edit_kontak" class="af-input">
                    </div>
                    <div class="af-group">
                        <label class="af-label">Status <span class="req">*</span></label>
                        <select name="status" id="edit_status" class="af-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="alumni">Alumni</option>
                            <option value="pindah">Pindah</option>
                            <option value="keluar">Keluar</option>
                        </select>
                    </div>
                    <div class="af-group">
                        <label class="af-label">Foto Baru (opsional)</label>
                        <input type="file" name="foto" class="af-file" accept="image/*">
                        <p class="af-hint">Kosongkan jika tidak ingin mengganti foto</p>
                    </div>
                </div>
            </div>
            <div class="amodal-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ========= MODAL: IMPORT EXCEL ========= --}}
<div class="amodal-backdrop" id="importModal">
    <div class="amodal">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-file-earmark-excel-fill" style="color:#16a34a;"></i>
                Import Data Siswa
            </span>
            <button class="amodal-close" onclick="closeModal('importModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="amodal-body">
            {{-- Info box --}}
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px;">
                <div style="font-weight: 700; color: #16a34a; font-size: 0.875rem; margin-bottom: 6px;">
                    <i class="bi bi-info-circle-fill me-1"></i> Panduan Import
                </div>
                <ul style="font-size: 0.82rem; color: #374151; margin: 0; padding-left: 18px; line-height: 1.8;">
                    <li>Gunakan template yang tersedia untuk format yang benar</li>
                    <li>Kolom: NIS | Nama | Kelas | JK (L/P) | Tempat Lahir | Tgl Lahir | Alamat | Nama Wali | Kontak Wali | Status</li>
                    <li>Format file: <strong>CSV</strong> atau <strong>Excel (.xlsx)</strong></li>
                    <li>Data dengan NIS yang sudah ada akan <strong>diperbarui</strong> otomatis</li>
                    <li>Baris pertama (header) akan dilewati secara otomatis</li>
                </ul>
            </div>

            {{-- Upload area --}}
            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="af-group">
                    <label class="af-label">Pilih File <span class="req">*</span></label>
                    <div id="dropZone" onclick="document.getElementById('importFile').click()" style="
                        border: 2px dashed #d1d5db;
                        border-radius: 12px;
                        padding: 32px;
                        text-align: center;
                        cursor: pointer;
                        transition: all 0.2s;
                        background: #fafafa;
                    ">
                        <i class="bi bi-cloud-arrow-up" style="font-size: 2.5rem; color: var(--primary); display: block; margin-bottom: 10px;"></i>
                        <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">
                            Klik atau seret file ke sini
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">CSV atau Excel (.xlsx, .xls) — Maks 5MB</div>
                        <div id="fileNameDisplay" style="margin-top: 10px; font-weight: 600; color: var(--primary); font-size: 0.84rem; display: none;"></div>
                    </div>
                    <input type="file" name="file" id="importFile" accept=".csv,.xlsx,.xls,.txt"
                           style="display:none;" required onchange="showFileName(this)">
                </div>

                <div style="display: flex; gap: 10px; align-items: center; margin-top: 4px;">
                    <span style="font-size: 0.78rem; color: var(--text-muted);">
                        <i class="bi bi-info-circle"></i>
                        Butuh template? Hubungi administrator atau lihat panduan di atas.
                    </span>
                </div>

                <div class="amodal-footer" style="padding: 14px 0 0; border-top: none; margin-top: 16px;">
                    <button type="button" class="ab ab-secondary" onclick="closeModal('importModal')">Batal</button>
                    <button type="submit" class="ab ab-success" id="importBtn">
                        <i class="bi bi-upload"></i> Mulai Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
    // ── Modal helpers ──
    function openModal(id) {
        document.getElementById(id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
        document.body.style.overflow = '';
    }
    // Close on backdrop click
    document.querySelectorAll('.amodal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // ── Edit modal ──
    function openEditModal(id, data) {
        document.getElementById('editForm').action = '/admin/siswa/' + id;
        document.getElementById('edit_nis').value    = data.nis      || '';
        document.getElementById('edit_nisn').value   = data.nisn     || '';
        document.getElementById('edit_nik').value    = data.nik      || '';
        document.getElementById('edit_nama').value   = data.nama     || '';
        document.getElementById('edit_kelas').value  = data.kelas    || '';
        document.getElementById('edit_jk').value     = data.jenis_kelamin || 'L';
        document.getElementById('edit_tl').value     = data.tempat_lahir  || '';
        document.getElementById('edit_ttl').value    = data.tanggal_lahir ? data.tanggal_lahir.substring(0, 10) : '';
        document.getElementById('edit_alamat').value = data.alamat    || '';
        document.getElementById('edit_wali').value   = data.nama_wali || '';
        document.getElementById('edit_kontak').value = data.kontak_wali || '';
        document.getElementById('edit_status').value = data.status    || 'aktif';
        openModal('editModal');
    }

    // ── Import: show filename ──
    function showFileName(input) {
        const display = document.getElementById('fileNameDisplay');
        const zone    = document.getElementById('dropZone');
        if (input.files && input.files[0]) {
            display.textContent = '✓ ' + input.files[0].name;
            display.style.display = 'block';
            zone.style.borderColor = 'var(--primary)';
            zone.style.background  = 'var(--primary-soft)';
        }
    }

    // ── Drag & drop ──
    const dropZone = document.getElementById('dropZone');
    if (dropZone) {
        dropZone.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--primary)';
            dropZone.style.background  = 'var(--primary-soft)';
        });
        dropZone.addEventListener('dragleave', () => {
            dropZone.style.borderColor = '#d1d5db';
            dropZone.style.background  = '#fafafa';
        });
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            const file = e.dataTransfer.files[0];
            const inp  = document.getElementById('importFile');
            const dt   = new DataTransfer();
            dt.items.add(file);
            inp.files = dt.files;
            showFileName(inp);
        });
    }

    // ── Loading state on import submit ──
    document.getElementById('importForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('importBtn');
        btn.disabled = true;
        btn.innerHTML = '<span style="display:inline-block;width:14px;height:14px;border:2px solid rgba(255,255,255,0.4);border-top-color:#fff;border-radius:50%;animation:spin 0.8s linear infinite;vertical-align:middle;margin-right:6px;"></span> Mengimpor...';
    });
</script>
<style>
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@endsection
