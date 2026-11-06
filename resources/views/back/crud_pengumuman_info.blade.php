@extends('layouts.admin.app')

@section('title', 'Kelola Pengumuman')
@section('page-title', 'Pengumuman')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Konten Website</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Pengumuman</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Pengumuman Sekolah</h1>
            <p class="page-subtitle">Kelola pengumuman resmi dan surat edaran sekolah</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Pengumuman
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
            <span class="stat-card-label">Total Pengumuman</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-megaphone-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Semua edaran</span>
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
            Daftar Pengumuman
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} pengumuman)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari judul..." 
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
                        <th style="min-width: 200px;">Judul Pengumuman</th>
                        <th>Tanggal Publikasi</th>
                        <th>Lampiran</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                    <tr class="data-row" data-judul="{{ strtolower($item->judul) }}">
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $item->judul }}</strong>
                            @if($item->isi)
                                <div style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.4; max-width: 450px;">{{ Str::limit(strip_tags($item->isi), 90) }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.84rem; font-weight: 600; color: var(--text-primary);">
                                <i class="bi bi-calendar-event me-1 text-primary"></i>
                                {{ $item->tanggal_publikasi ? $item->tanggal_publikasi->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            @if($item->lampiran)
                                <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank" class="ab ab-sm ab-outline" style="text-decoration: none;">
                                    <i class="bi bi-paperclip"></i> Unduh
                                </a>
                            @else
                                <span class="text-muted" style="font-size: 0.8rem;">-</span>
                            @endif
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
                                        title="Edit Pengumuman">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $item->id }}"
                                        title="Hapus Pengumuman">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.pengumuman.destroy', $item->id) }}"
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
                            Belum ada pengumuman. Klik tombol <strong>Tambah Pengumuman</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: TAMBAH PENGUMUMAN ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-plus-circle-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Pengumuman Baru
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Judul Pengumuman <span class="req">*</span></label>
                        <input type="text" name="judul" class="af-input" placeholder="e.g. Edaran Libur Hari Raya Idul Fitri" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Publikasi <span class="req">*</span></label>
                        <input type="date" name="tanggal_publikasi" class="af-input" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Lampiran Berkas (PDF / Dokumen / Gambar)</label>
                        <input type="file" name="lampiran" class="af-file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <p class="af-hint">Maksimal 5MB</p>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Isi Pengumuman <span class="req">*</span></label>
                        <textarea name="isi" class="af-textarea" rows="5" placeholder="Tuliskan isi pengumuman secara lengkap..." required></textarea>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan dan tampilkan di website</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="amodal-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT PENGUMUMAN ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Pengumuman
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
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Judul Pengumuman <span class="req">*</span></label>
                        <input type="text" name="judul" id="edit_judul" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Publikasi <span class="req">*</span></label>
                        <input type="date" name="tanggal_publikasi" id="edit_tanggal_publikasi" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Ganti Lampiran (opsional)</label>
                        <div id="edit_lampiran_preview" class="mb-2"></div>
                        <input type="file" name="lampiran" class="af-file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <p class="af-hint">Kosongkan jika tidak mengganti lampiran.</p>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Isi Pengumuman <span class="req">*</span></label>
                        <textarea name="isi" id="edit_isi" class="af-textarea" rows="5" required></textarea>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan dan tampilkan di website</span>
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
        form.action = "{{ url('admin/pengumuman') }}/" + item.id;

        document.getElementById('edit_judul').value = item.judul || '';
        document.getElementById('edit_tanggal_publikasi').value = item.tanggal_publikasi ? item.tanggal_publikasi.substring(0, 10) : '';
        document.getElementById('edit_isi').value = item.isi || '';
        document.getElementById('edit_is_active').checked = !!item.is_active;

        const preview = document.getElementById('edit_lampiran_preview');
        if (item.lampiran) {
            preview.innerHTML = `
                <div class="d-flex align-items-center gap-2" style="background: #f9fafb; padding: 6px 10px; border-radius: 6px; border: 1px solid var(--border); font-size: 0.8rem;">
                    <i class="bi bi-file-earmark-check text-success"></i>
                    <span>Lampiran saat ini terunggah</span>
                </div>
            `;
        } else {
            preview.innerHTML = '';
        }

        openModal('editModal');
    }

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.data-row').forEach(row => {
                const judul = row.getAttribute('data-judul') || '';
                if (!query || judul.includes(query)) {
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
