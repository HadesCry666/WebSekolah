@extends('layouts.admin.app')

@section('title', 'Guru & Staf')
@section('page-title', 'Guru & Staf')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Guru & Staf</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Guru & Staf</h1>
            <p class="page-subtitle">Kelola data tenaga pendidik dan tenaga kependidikan</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Guru & Staf
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

{{-- Stat Cards --}}
<div class="stat-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Total Tenaga Pendidik</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['total'] ?? $data->total() }}</div>
        <span class="stat-card-link">Total keseluruhan data</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Kepala Sekolah</span>
            <div class="stat-card-icon" style="background: rgba(16, 185, 129, 0.15); color: #059669;"><i class="bi bi-person-badge-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['kepala_sekolah'] ?? 0 }}</div>
        <span class="stat-card-link">Pimpinan Sekolah</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Guru Pengajar</span>
            <div class="stat-card-icon ic-info"><i class="bi bi-mortarboard-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['guru'] ?? 0 }}</div>
        <span class="stat-card-link">Tenaga pendidik mata pelajaran</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Tata Usaha</span>
            <div class="stat-card-icon ic-warning"><i class="bi bi-briefcase-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['tata_usaha'] ?? 0 }}</div>
        <span class="stat-card-link">Staf kependidikan & administrasi</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Ustadz / Ustadzah</span>
            <div class="stat-card-icon ic-success"><i class="bi bi-book-half"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['ustadz'] ?? 0 }}</div>
        <span class="stat-card-link">Pengajar Al-Qur'an & Diniyah</span>
    </div>
</div>

{{-- Data Table Card --}}
<div class="ac">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-table"></i>
            Daftar Guru & Staf
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->total() }} orang)
            </span>
        </span>
        <form method="GET" action="{{ route('admin.tenaga-pendidik.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="af-input" placeholder="Cari nama, NIP, mapel..." 
                       style="padding-left: 30px; height: 36px; font-size: 0.82rem; min-width: 200px;">
            </div>
            <select name="jabatan" class="af-select" onchange="this.form.submit()" style="height: 36px; font-size: 0.82rem; min-width: 140px;">
                <option value="">Semua Jabatan</option>
                <option value="Kepala Sekolah" {{ in_array(request('jabatan'), ['Kepala Sekolah', 'kepala_sekolah']) ? 'selected' : '' }}>Kepala Sekolah</option>
                <option value="Guru" {{ request('jabatan') == 'Guru' ? 'selected' : '' }}>Guru</option>
                <option value="Tata usaha" {{ in_array(request('jabatan'), ['Tata usaha', 'Tata Usaha', 'tata_usaha']) ? 'selected' : '' }}>Tata Usaha</option>
                <option value="Ustadz" {{ request('jabatan') == 'Ustadz' ? 'selected' : '' }}>Ustadz</option>
            </select>
            <select name="per_page" class="af-select" onchange="this.form.submit()" style="height: 36px; font-size: 0.82rem; min-width: 105px;">
                <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 baris</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <button type="submit" class="ab ab-sm ab-primary" style="height: 36px;">
                <i class="bi bi-funnel"></i> Cari
            </button>
            @if(request()->filled('search') || request()->filled('jabatan') || request()->filled('per_page'))
                <a href="{{ route('admin.tenaga-pendidik.index') }}" class="ab ab-sm ab-secondary" style="height: 36px;" title="Reset Filter">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div class="ac-body-flush">
        <div class="table-responsive">
            <table class="at" id="tableGuru">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th>Foto & Nama</th>
                        <th>Jabatan</th>
                        <th>Mata Pelajaran</th>
                        <th>NIP</th>
                        <th>Pendidikan</th>
                        <th>JK</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $row)
                    <tr>
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $data->firstItem() + $i }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                {{-- Avatar Foto --}}
                                @if($row->foto)
                                    <img src="{{ image_url($row->foto) }}" 
                                         alt="{{ $row->nama }}" 
                                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--border); flex-shrink: 0;"
                                         onerror="this.onerror=null; this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $row->jenis_kelamin == 'Perempuan' ? 'linear-gradient(135deg, #fce7f3, #fbcfe8)' : 'linear-gradient(135deg, #e0e7ff, #c7d2fe)' }}; color: {{ $row->jenis_kelamin == 'Perempuan' ? '#be185d' : '#4338ca' }}; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                                        {{ strtoupper(substr($row->nama, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary); font-size: 0.88rem;">{{ $row->nama }}</div>
                                    @if($row->tempat_lahir || $row->tanggal_lahir)
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                                            {{ $row->tempat_lahir ? $row->tempat_lahir : '' }}
                                            {{ $row->tempat_lahir && $row->tanggal_lahir ? ', ' : '' }}
                                            {{ $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y') : '' }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $rawJ = strtolower(str_replace([' ', '_'], '', $row->jabatan));
                                if (str_contains($rawJ, 'kepala')) {
                                    $badgeClass = 'badge-primary';
                                    $labelJabatan = 'Kepala Sekolah';
                                } elseif ($rawJ === 'ustadz') {
                                    $badgeClass = 'badge-success';
                                    $labelJabatan = 'Ustadz';
                                } elseif (str_contains($rawJ, 'tata')) {
                                    $badgeClass = 'badge-warning';
                                    $labelJabatan = 'Tata Usaha';
                                } elseif ($rawJ === 'guru') {
                                    $badgeClass = 'badge-info';
                                    $labelJabatan = 'Guru';
                                } else {
                                    $badgeClass = 'badge-secondary';
                                    $labelJabatan = $row->jabatan;
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}" style="font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                                @if(str_contains($rawJ, 'kepala'))
                                    <i class="bi bi-person-badge me-1"></i>
                                @endif
                                {{ $labelJabatan }}
                            </span>
                        </td>
                        <td>
                            {{ $row->mata_pelajaran ?: '-' }}
                        </td>
                        <td>
                            @if($row->NIP)
                                <code style="font-size: 0.8rem; background: #f3f4f6; padding: 2px 6px; border-radius: 4px; color: var(--text-primary);">
                                    {{ $row->NIP }}
                                </code>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            {{ $row->pendidikan_terakhir ?: '-' }}
                        </td>
                        <td>
                            <span style="font-size: 0.8rem; font-weight: 600; color: {{ $row->jenis_kelamin == 'Perempuan' ? '#be185d' : '#1d4ed8' }};">
                                {{ $row->jenis_kelamin == 'Perempuan' ? 'P' : ($row->jenis_kelamin == 'Laki-laki' ? 'L' : '-') }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-inline-flex gap-1">
                                {{-- Tombol Edit --}}
                                <button type="button" class="ab ab-sm ab-secondary" 
                                        onclick="openEditModal({{ json_encode($row) }})"
                                        title="Edit Data Guru & Staf">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $row->id }}"
                                        title="Hapus Data">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $row->id }}" 
                                      action="{{ route('admin.tenaga-pendidik.destroy', $row->id) }}"
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="8" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size: 2.2rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                            Belum ada data tenaga pendidik. Klik tombol <strong>Tambah Guru & Staf</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Modern --}}
        {{ $data->links('partials.pagination') }}
    </div>
</div>

{{-- ================= MODAL: TAMBAH GURU & STAF ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-person-plus-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Data Guru & Staf
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.tenaga-pendidik.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    {{-- Nama --}}
                    <div class="af-group">
                        <label class="af-label">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama" class="af-input" placeholder="e.g. Ahmad Fauzi, S.Pd" required>
                    </div>

                    {{-- Jabatan --}}
                    <div class="af-group">
                        <label class="af-label">Jabatan <span class="req">*</span></label>
                        <select name="jabatan" class="af-select" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                            <option value="Guru">Guru</option>
                            <option value="Tata usaha">Tata Usaha</option>
                            <option value="Ustadz">Ustadz</option>
                        </select>
                    </div>

                    {{-- Mata Pelajaran --}}
                    <div class="af-group">
                        <label class="af-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="af-input" placeholder="e.g. Matematika / IPA / PAI">
                    </div>

                    {{-- NIP --}}
                    <div class="af-group">
                        <label class="af-label">NIP</label>
                        <input type="text" name="NIP" class="af-input" placeholder="Nomor Induk Pegawai (opsional)">
                    </div>

                    {{-- Pendidikan Terakhir --}}
                    <div class="af-group">
                        <label class="af-label">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" class="af-input" placeholder="e.g. S1 Pendidikan Agama Islam">
                    </div>

                    {{-- Agama --}}
                    <div class="af-group">
                        <label class="af-label">Agama</label>
                        <input type="text" name="agama" class="af-input" value="Islam" placeholder="Agama">
                    </div>

                    {{-- Tempat Lahir --}}
                    <div class="af-group">
                        <label class="af-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="af-input" placeholder="Kota / Kabupaten">
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="af-group">
                        <label class="af-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="af-input">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="af-group">
                        <label class="af-label">Jenis Kelamin <span class="req">*</span></label>
                        <select name="jenis_kelamin" class="af-select" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    {{-- Foto --}}
                    <div class="af-group">
                        <label class="af-label">Foto Profil (opsional)</label>
                        <input type="file" name="foto" class="af-file" accept="image/png, image/jpeg, image/jpg">
                        <p class="af-hint">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                    </div>

                    {{-- Alamat --}}
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="af-textarea" rows="2" placeholder="Alamat domisili saat ini"></textarea>
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

{{-- ================= MODAL: EDIT GURU & STAF ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Data Guru & Staf
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('editModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="editGuruForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="amodal-body">
                <div class="ag ag-2">
                    {{-- Nama --}}
                    <div class="af-group">
                        <label class="af-label">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama" id="edit_nama" class="af-input" required>
                    </div>

                    {{-- Jabatan --}}
                    <div class="af-group">
                        <label class="af-label">Jabatan <span class="req">*</span></label>
                        <select name="jabatan" id="edit_jabatan" class="af-select" required>
                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                            <option value="Guru">Guru</option>
                            <option value="Tata usaha">Tata Usaha</option>
                            <option value="Ustadz">Ustadz</option>
                        </select>
                    </div>

                    {{-- Mata Pelajaran --}}
                    <div class="af-group">
                        <label class="af-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" id="edit_mata_pelajaran" class="af-input">
                    </div>

                    {{-- NIP --}}
                    <div class="af-group">
                        <label class="af-label">NIP</label>
                        <input type="text" name="NIP" id="edit_nip" class="af-input">
                    </div>

                    {{-- Pendidikan Terakhir --}}
                    <div class="af-group">
                        <label class="af-label">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" id="edit_pendidikan_terakhir" class="af-input">
                    </div>

                    {{-- Agama --}}
                    <div class="af-group">
                        <label class="af-label">Agama</label>
                        <input type="text" name="agama" id="edit_agama" class="af-input">
                    </div>

                    {{-- Tempat Lahir --}}
                    <div class="af-group">
                        <label class="af-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="af-input">
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="af-group">
                        <label class="af-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="af-input">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="af-group">
                        <label class="af-label">Jenis Kelamin <span class="req">*</span></label>
                        <select name="jenis_kelamin" id="edit_jenis_kelamin" class="af-select" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    {{-- Foto --}}
                    <div class="af-group">
                        <label class="af-label">Foto Profil (opsional)</label>
                        <div id="edit_foto_preview" class="mb-2"></div>
                        <input type="file" name="foto" class="af-file" accept="image/png, image/jpeg, image/jpg">
                        <p class="af-hint">Format: JPG, JPEG, PNG. Kosongkan bila tidak ingin mengubah foto.</p>
                    </div>

                    {{-- Alamat --}}
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="edit_alamat" class="af-textarea" rows="2"></textarea>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script>
    // ── Modal Helper ──
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    // Close on backdrop click
    document.querySelectorAll('.amodal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.amodal-backdrop.show').forEach(el => closeModal(el.id));
        }
    });

    // ── Open Edit Modal ──
    function openEditModal(row) {
        const form = document.getElementById('editGuruForm');
        form.action = "{{ url('admin/tenaga-pendidik') }}/" + row.id;

        document.getElementById('edit_nama').value = row.nama || '';
        
        // Handle Jabatan case-insensitively / space
        const jabatanSelect = document.getElementById('edit_jabatan');
        const rawJabatan = (row.jabatan || 'Guru').trim();
        if (/kepala.*sekolah/i.test(rawJabatan)) {
            jabatanSelect.value = 'Kepala Sekolah';
        } else if (/tata.*usaha/i.test(rawJabatan)) {
            jabatanSelect.value = 'Tata usaha';
        } else if (/ustadz/i.test(rawJabatan)) {
            jabatanSelect.value = 'Ustadz';
        } else {
            jabatanSelect.value = 'Guru';
        }

        document.getElementById('edit_mata_pelajaran').value = row.mata_pelajaran || '';
        document.getElementById('edit_nip').value = row.NIP || '';
        document.getElementById('edit_pendidikan_terakhir').value = row.pendidikan_terakhir || '';
        document.getElementById('edit_agama').value = row.agama || '';
        document.getElementById('edit_tempat_lahir').value = row.tempat_lahir || '';
        document.getElementById('edit_tanggal_lahir').value = row.tanggal_lahir ? row.tanggal_lahir.substring(0, 10) : '';
        document.getElementById('edit_jenis_kelamin').value = row.jenis_kelamin || 'Laki-laki';
        document.getElementById('edit_alamat').value = row.alamat || '';

        // Foto preview
        const fotoPreview = document.getElementById('edit_foto_preview');
        if (row.foto) {
            const fotoSrc = (row.foto.startsWith('data:') || row.foto.startsWith('http')) ? row.foto : '{{ asset('storage') }}/' + row.foto;
            fotoPreview.innerHTML = `
                <div class="d-flex align-items-center gap-2" style="background: #f9fafb; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border);">
                    <img src="${fotoSrc}" alt="${row.nama}" 
                         style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border);"
                         onerror="this.onerror=null; this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';">
                    <div>
                        <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-primary);">Foto tersimpan</div>
                        <div style="font-size: 0.7rem; color: var(--text-muted);">Pilih file baru jika ingin mengganti</div>
                    </div>
                </div>
            `;
        } else {
            fotoPreview.innerHTML = `
                <div style="font-size: 0.78rem; color: var(--text-muted); background: #f9fafb; padding: 6px 12px; border-radius: 8px; border: 1px dashed var(--border);">
                    <i class="bi bi-image" style="margin-right: 4px;"></i> Belum ada foto profil
                </div>
            `;
        }

        openModal('editModal');
    }
</script>
@endpush

@endsection
