@extends('layouts.admin.app')

@section('title', 'Manajemen Raport Siswa')
@section('page-title', 'Raport Siswa')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Akademik</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Raport Siswa</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Manajemen Raport Siswa</h1>
            <p class="page-subtitle">Unggah dan kelola file raport PDF untuk dibagikan kepada siswa secara online</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button class="ab ab-secondary" onclick="openModal('generateAkunModal')">
                <i class="bi bi-key-fill"></i> Generate Akun Siswa
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

{{-- STAT CARDS --}}
<div class="stat-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Siswa Aktif</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['total_siswa'] }}</div>
        <span class="stat-card-link">Total sasaran raport</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Sudah Upload</span>
            <div class="stat-card-icon ic-success"><i class="bi bi-file-earmark-check-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['sudah_upload'] }}</div>
        <span class="stat-card-link">{{ $tahunAjaranAktif }} - {{ ucfirst($semesterAktif) }}</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Belum Diunggah</span>
            <div class="stat-card-icon ic-warning"><i class="bi bi-file-earmark-x-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['belum_upload'] }}</div>
        <span class="stat-card-link">Perlu dilengkapi</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Akun Siswa Siap</span>
            <div class="stat-card-icon ic-info"><i class="bi bi-person-badge-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $stats['akun_siswa'] }}</div>
        <span class="stat-card-link">Dapat login dengan NIS</span>
    </div>
</div>

{{-- FILTER & SEARCH --}}
<div class="ac" style="margin-bottom: 20px;">
    <div class="ac-body" style="padding: 16px 20px;">
        <form method="GET" action="{{ route('admin.raport.index') }}" class="d-flex gap-3 flex-wrap align-items-end">
            {{-- Filter Tahun Ajaran --}}
            <div style="min-width: 160px;">
                <label class="af-label" style="margin-bottom: 6px;">Tahun Ajaran</label>
                <select name="tahun_ajaran" class="af-select" onchange="this.form.submit()">
                    @foreach($tahunAjaranList as $ta)
                        <option value="{{ $ta }}" {{ $tahunAjaranAktif == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Semester --}}
            <div style="min-width: 140px;">
                <label class="af-label" style="margin-bottom: 6px;">Semester</label>
                <select name="semester" class="af-select" onchange="this.form.submit()">
                    <option value="ganjil" {{ $semesterAktif == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap" {{ $semesterAktif == 'genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>

            {{-- Filter Kelas --}}
            <div style="min-width: 130px;">
                <label class="af-label" style="margin-bottom: 6px;">Kelas</label>
                <select name="kelas" class="af-select" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ $kelasAktif == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Cari Nama / NIS --}}
            <div style="flex: 1; min-width: 220px;">
                <label class="af-label" style="margin-bottom: 6px;">Cari Siswa</label>
                <div style="position: relative;">
                    <i class="bi bi-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:0.85rem;"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           class="af-input" placeholder="Ketik nama atau NIS..."
                           style="padding-left: 36px;">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="ab ab-primary" style="height: 42px;">
                    <i class="bi bi-funnel"></i> Terapkan
                </button>
                @if($search || $kelasAktif)
                <a href="{{ route('admin.raport.index', ['tahun_ajaran' => $tahunAjaranAktif, 'semester' => $semesterAktif]) }}"
                   class="ab ab-secondary" style="height: 42px;" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- INFO BANNER --}}
<div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <i class="bi bi-info-circle-fill" style="color: #2563eb; font-size: 1.25rem;"></i>
        <div style="font-size: 0.88rem; color: #1e40af;">
            Menampilkan data untuk <strong>Tahun Ajaran {{ $tahunAjaranAktif }} - Semester {{ ucfirst($semesterAktif) }}</strong>.
            Siswa dapat mendownload raport mereka jika statusnya <strong>Publik</strong>.
        </div>
    </div>
    <span class="badge" style="background: #2563eb; color: #fff; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem;">
        Total: {{ $siswa->total() }} Siswa
    </span>
</div>

{{-- TABEL SISWA & RAPORT --}}
<div class="ac">
    <div class="ac-body" style="padding: 0;">
        <div style="overflow-x: auto;">
            <table class="at-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Akun Portal Siswa</th>
                        <th>Status Raport</th>
                        <th>Status Rilis</th>
                        <th style="width: 220px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $item)
                        @php
                            $raport = $item->raports->first();
                            $hasAccount = $item->user !== null;
                        @endphp
                        <tr>
                            <td style="text-align: center; color: #9ca3af; font-size: 0.85rem;">
                                {{ $siswa->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; flex-shrink: 0; overflow: hidden;">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            {{ strtoupper(substr($item->nama, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #111827; font-size: 0.9rem;">{{ $item->nama }}</div>
                                        <div style="font-size: 0.76rem; color: #6b7280; display: flex; gap: 8px; flex-wrap: wrap; margin-top: 3px;">
                                            <span>NISN: <strong style="color: #0284c7;">{{ $item->nisn ?? '-' }}</strong></span>
                                            <span>•</span>
                                            <span>NIK: <strong style="color: #334155;">{{ $item->nik ?? '-' }}</strong></span>
                                            <span>•</span>
                                            <span>NIS: {{ $item->nis }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem;">
                                    Kelas {{ $item->kelas ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($hasAccount)
                                    <div>
                                        <span style="display: inline-flex; align-items: center; gap: 5px; font-size: 0.8rem; color: #16a34a; font-weight: 600;">
                                            <i class="bi bi-check-circle-fill"></i> Siap Login
                                        </span>
                                        <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;">
                                            User: <strong>{{ $item->user->username ?? $item->nisn ?? $item->nis }}</strong>
                                        </div>
                                    </div>
                                @else
                                    <span style="display: inline-flex; align-items: center; gap: 5px; font-size: 0.8rem; color: #9ca3af;">
                                        <i class="bi bi-dash-circle"></i> Belum ada akun
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($raport)
                                    <div>
                                        <span class="badge" style="background: #dcfce7; color: #15803d; padding: 5px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                                            <i class="bi bi-file-earmark-pdf-fill"></i> Sudah Diunggah
                                        </span>
                                        <div style="font-size: 0.72rem; color: #6b7280; margin-top: 3px;">
                                            {{ $raport->updated_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                @else
                                    <span class="badge" style="background: #fef2f2; color: #b91c1c; padding: 5px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                                        <i class="bi bi-clock-history"></i> Belum Ada
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($raport)
                                    <form action="{{ route('admin.raport.publish', $raport->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @if($raport->is_published)
                                            <button type="submit" class="badge" style="background: #dbeafe; color: #1d4ed8; border: none; cursor: pointer; padding: 5px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;" title="Klik untuk ubah ke Draft">
                                                <i class="bi bi-eye-fill"></i> Publik
                                            </button>
                                        @else
                                            <button type="submit" class="badge" style="background: #f3f4f6; color: #6b7280; border: none; cursor: pointer; padding: 5px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;" title="Klik untuk Publikasikan">
                                                <i class="bi bi-eye-slash-fill"></i> Draft (Ditahan)
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <span style="color: #9ca3af; font-size: 0.8rem;">-</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div class="d-flex gap-1 justify-content-end align-items-center">
                                    {{-- Tombol Upload / Ganti --}}
                                    <button class="ab {{ $raport ? 'ab-secondary' : 'ab-primary' }} ab-sm"
                                            onclick="openUploadModal({{ $item->id }}, '{{ addslashes($item->nama) }}', '{{ $item->nis }}', '{{ $item->kelas }}', {{ $raport ? 'true' : 'false' }})"
                                            title="{{ $raport ? 'Ganti File Raport' : 'Upload Raport' }}">
                                        <i class="bi {{ $raport ? 'bi-arrow-repeat' : 'bi-cloud-arrow-up-fill' }}"></i>
                                        <span>{{ $raport ? 'Ganti' : 'Upload' }}</span>
                                    </button>

                                    @if($raport)
                                        {{-- Preview PDF --}}
                                        <a href="{{ route('admin.raport.preview', $raport->id) }}"
                                           target="_blank"
                                           class="ab ab-secondary ab-sm"
                                           title="Lihat PDF di Tab Baru">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Download PDF --}}
                                        <a href="{{ route('admin.raport.download', $raport->id) }}"
                                           class="ab ab-secondary ab-sm"
                                           title="Download PDF">
                                            <i class="bi bi-download"></i>
                                        </a>

                                        {{-- Hapus Raport --}}
                                        <form action="{{ route('admin.raport.destroy', $raport->id) }}"
                                              method="POST"
                                              style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus file raport milik {{ addslashes($item->nama) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ab ab-danger ab-sm" title="Hapus Raport">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 48px 20px; color: #6b7280;">
                                <div style="font-size: 2.5rem; margin-bottom: 8px; color: #9ca3af;">
                                    <i class="bi bi-folder-x"></i>
                                </div>
                                <div style="font-weight: 600; font-size: 1rem; color: #374151;">Tidak ada data siswa ditemukan</div>
                                <div style="font-size: 0.85rem; margin-top: 4px;">Coba ubah filter kelas atau kata kunci pencarian.</div>
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

{{-- ── MODAL UPLOAD RAPORT ── --}}
<div class="modal-backdrop-custom" id="uploadModal" style="display: none;">
    <div class="modal-box-custom" style="max-width: 520px;">
        <div class="modal-box-header">
            <div>
                <h3 class="modal-box-title" id="modalUploadTitle">Upload Raport Siswa</h3>
                <p class="modal-box-sub" id="modalUploadSub">Pilih berkas PDF raport untuk siswa</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('uploadModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.raport.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="siswa_id" id="uploadSiswaId">

            <div class="modal-box-body">
                {{-- Info Siswa Card --}}
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Target Siswa:</div>
                    <div style="font-weight: 700; color: #0f172a; font-size: 1rem;" id="modalSiswaNama">-</div>
                    <div style="font-size: 0.82rem; color: #475569;" id="modalSiswaNis">-</div>
                </div>

                {{-- Periode --}}
                <div class="d-flex gap-2" style="margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label class="af-label">Tahun Ajaran <span style="color:red;">*</span></label>
                        <input type="text" name="tahun_ajaran" id="uploadTahunAjaran" class="af-input" value="{{ $tahunAjaranAktif }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="af-label">Semester <span style="color:red;">*</span></label>
                        <select name="semester" id="uploadSemester" class="af-select" required>
                            <option value="ganjil" {{ $semesterAktif == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ $semesterAktif == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                </div>

                {{-- File PDF --}}
                <div style="margin-bottom: 16px;">
                    <label class="af-label">File Raport (Format PDF) <span style="color:red;">*</span></label>
                    <input type="file" name="file_raport" class="af-input" accept="application/pdf" required>
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">
                        <i class="bi bi-info-circle"></i> Ukuran maksimal 10 MB. Format wajib .pdf
                    </div>
                </div>

                {{-- Catatan (opsional) --}}
                <div style="margin-bottom: 16px;">
                    <label class="af-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" class="af-input" rows="2" placeholder="Contoh: Raport kenaikan kelas dengan catatan kehadiran memuaskan..."></textarea>
                </div>

                {{-- Status Publikasi Langsung --}}
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 14px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0; font-size: 0.88rem; font-weight: 600; color: #166534;">
                        <input type="checkbox" name="is_published" value="1" checked style="width: 16px; height: 16px;">
                        Langsung publikasikan agar dapat didownload siswa
                    </label>
                </div>
            </div>

            <div class="modal-box-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('uploadModal')">Batal</button>
                <button type="submit" class="ab ab-primary" id="btnSubmitUpload">
                    <i class="bi bi-cloud-arrow-up-fill"></i> Simpan Raport
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL GENERATE AKUN SISWA ── --}}
<div class="modal-backdrop-custom" id="generateAkunModal" style="display: none;">
    <div class="modal-box-custom" style="max-width: 500px;">
        <div class="modal-box-header">
            <div>
                <h3 class="modal-box-title">Generate Akun Login Siswa</h3>
                <p class="modal-box-sub">Buat akses login siswa otomatis berbasis Nomor Induk Siswa</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('generateAkunModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.raport.generateAkun') }}" method="POST">
            @csrf
            <div class="modal-box-body">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px; margin-bottom: 16px;">
                    <div style="font-weight: 700; color: #1e40af; font-size: 0.9rem; margin-bottom: 6px;">
                        <i class="bi bi-shield-lock-fill"></i> Ketentuan Kredensial Siswa:
                    </div>
                    <ul style="font-size: 0.82rem; color: #1e3a8a; margin: 0; padding-left: 18px; line-height: 1.6;">
                        <li><strong>Username:</strong> Nomor Induk Siswa Nasional (NISN) masing-masing.</li>
                        <li><strong>Password Awal:</strong> Nomor Induk Kependudukan (NIK) masing-masing.</li>
                        <li><strong>Role:</strong> Siswa (hanya bisa mengakses portal download raport).</li>
                    </ul>
                </div>

                <div>
                    <label class="af-label">Pilih Target Siswa</label>
                    <select name="kelas" class="af-select">
                        <option value="">Semua Siswa Aktif (Seluruh Kelas)</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}">Khusus Siswa Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 5px;">
                        Sistem hanya akan membuatkan akun bagi siswa yang belum memiliki akun login.
                    </div>
                </div>
            </div>

            <div class="modal-box-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('generateAkunModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Mulai Generate Akun
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL STYLES & JS SCRIPT --}}
<style>
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .modal-box-custom {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .modal-box-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-box-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .modal-box-sub {
        font-size: 0.8rem;
        color: #64748b;
        margin: 4px 0 0;
    }
    .modal-close-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .modal-close-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .modal-box-body {
        padding: 24px;
    }
    .modal-box-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>

<script>
    function openModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'flex';
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    }

    function openUploadModal(siswaId, nama, nis, kelas, hasRaport) {
        document.getElementById('uploadSiswaId').value = siswaId;
        document.getElementById('modalSiswaNama').textContent = nama;
        document.getElementById('modalSiswaNis').textContent = 'NIS: ' + nis + ' • Kelas: ' + (kelas || '-');
        
        const title = document.getElementById('modalUploadTitle');
        const sub = document.getElementById('modalUploadSub');
        const btn = document.getElementById('btnSubmitUpload');
        
        if (hasRaport) {
            title.textContent = 'Ganti File Raport';
            sub.textContent = 'File lama akan digantikan dengan berkas baru yang Anda unggah';
            btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Perbarui Raport';
        } else {
            title.textContent = 'Upload Raport Siswa';
            sub.textContent = 'Unggah berkas raport format PDF untuk siswa ini';
            btn.innerHTML = '<i class="bi bi-cloud-arrow-up-fill"></i> Simpan Raport';
        }

        openModal('uploadModal');
    }

    // Close modal on click backdrop
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop-custom')) {
            e.target.style.display = 'none';
        }
    });
</script>

@endsection
