@extends('layouts.admin.app')

@section('title', 'Program Unggulan')
@section('page-title', 'Program Unggulan')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Akademik</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Program Unggulan</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Program Unggulan</h1>
            <p class="page-subtitle">Kelola program unggulan khas SMP Sains Al-Qur'an Klakah</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Program
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

{{-- Stat Cards --}}
<div class="stat-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Total Program</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-star-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Program unggulan</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Status Aktif</span>
            <div class="stat-card-icon ic-success"><i class="bi bi-check-circle"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('is_active', true)->count() }}</div>
        <span class="stat-card-link">Tampil di beranda</span>
    </div>
</div>

{{-- Table Card --}}
<div class="ac">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-table"></i>
            Daftar Program Unggulan
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} program)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari program..." 
                       style="padding-left: 30px; height: 36px; font-size: 0.82rem; min-width: 220px;">
            </div>
        </div>
    </div>

    <div class="ac-body-flush">
        <div class="table-responsive">
            <table class="at" id="tableData">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th style="min-width: 200px;">Program & Ikon</th>
                        <th>Deskripsi</th>
                        <th style="width: 80px; text-align: center;">Urutan</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                    <tr class="data-row" data-nama="{{ strtolower($item->nama) }}">
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 38px; height: 38px; border-radius: 8px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                                    <i class="bi {{ $item->ikon ?? 'bi-star' }}"></i>
                                </div>
                                <div>
                                    <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $item->nama }}</strong>
                                    <div style="font-size: 0.72rem; color: var(--text-muted);">{{ $item->ikon ?: 'bi-star' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: var(--text-secondary); font-size: 0.84rem; line-height: 1.5; max-width: 500px;">
                                {{ Str::limit($item->deskripsi, 120) ?: '-' }}
                            </div>
                        </td>
                        <td style="text-align: center; font-weight: 600; color: var(--text-muted);">
                            {{ $item->urutan ?? 0 }}
                        </td>
                        <td style="text-align: center;">
                            <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-secondary' }}" 
                                  style="font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-inline-flex gap-1">
                                {{-- Tombol Edit --}}
                                <button type="button" class="ab ab-sm ab-secondary" 
                                        onclick="openEditModal({{ json_encode($item) }})"
                                        title="Edit Program">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $item->id }}"
                                        title="Hapus Program">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.program-unggulan.destroy', $item->id) }}"
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size: 2.2rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                            Belum ada program unggulan. Klik tombol <strong>Tambah Program</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: TAMBAH PROGRAM ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-plus-circle-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Program Unggulan
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.program-unggulan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group">
                        <label class="af-label">Nama Program <span class="req">*</span></label>
                        <input type="text" name="nama" class="af-input" placeholder="e.g. Tahfidz Al-Qur'an / Sains Terpadu" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Ikon (Bootstrap Icons)</label>
                        <input type="text" name="ikon" class="af-input" placeholder="e.g. bi-journal-bookmark-fill, bi-rocket-takeoff-fill, bi-heart-fill, bi-translate">
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.querySelector('#addModal input[name=ikon]').value='bi-journal-bookmark-fill'">📖 Tahfidz</span>
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.querySelector('#addModal input[name=ikon]').value='bi-rocket-takeoff-fill'">🚀 Sains & Tech</span>
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.querySelector('#addModal input[name=ikon]').value='bi-heart-fill'">❤️ Akhlak</span>
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.querySelector('#addModal input[name=ikon]').value='bi-translate'">🌐 Bahasa</span>
                        </div>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Urutan Tampil</label>
                        <input type="number" name="urutan" class="af-input" value="0">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Gambar Banner (opsional)</label>
                        <input type="file" name="gambar" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp">
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi</label>
                        <textarea name="deskripsi" class="af-textarea" rows="3" placeholder="Jelaskan tujuan dan keunggulan program ini..."></textarea>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan dan tampilkan di halaman depan</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="amodal-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Simpan Program
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT PROGRAM ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Program Unggulan
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('editModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group">
                        <label class="af-label">Nama Program <span class="req">*</span></label>
                        <input type="text" name="nama" id="edit_nama" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Ikon (Bootstrap Icons)</label>
                        <input type="text" name="ikon" id="edit_ikon" class="af-input" placeholder="e.g. bi-journal-bookmark-fill, bi-rocket-takeoff-fill, bi-heart-fill, bi-translate">
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.getElementById('edit_ikon').value='bi-journal-bookmark-fill'">📖 Tahfidz</span>
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.getElementById('edit_ikon').value='bi-rocket-takeoff-fill'">🚀 Sains & Tech</span>
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.getElementById('edit_ikon').value='bi-heart-fill'">❤️ Akhlak</span>
                            <span class="badge bg-light text-dark border" style="cursor:pointer; font-size: 0.72rem;" onclick="document.getElementById('edit_ikon').value='bi-translate'">🌐 Bahasa</span>
                        </div>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Urutan Tampil</label>
                        <input type="number" name="urutan" id="edit_urutan" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Ganti Gambar (opsional)</label>
                        <input type="file" name="gambar" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp">
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="af-textarea" rows="3"></textarea>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan dan tampilkan di halaman depan</span>
                        </label>
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

    document.querySelectorAll('.amodal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.amodal-backdrop.show').forEach(el => closeModal(el.id));
        }
    });

    function openEditModal(item) {
        const form = document.getElementById('editForm');
        form.action = "{{ url('admin/program-unggulan') }}/" + item.id;

        document.getElementById('edit_nama').value = item.nama || '';
        document.getElementById('edit_ikon').value = item.ikon || '';
        document.getElementById('edit_urutan').value = item.urutan ?? 0;
        document.getElementById('edit_deskripsi').value = item.deskripsi || '';
        document.getElementById('edit_is_active').checked = !!item.is_active;

        openModal('editModal');
    }

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.data-row').forEach(row => {
                const nama = row.getAttribute('data-nama') || '';
                if (!query || nama.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
</script>
@endpush

@endsection
