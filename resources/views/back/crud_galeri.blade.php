@extends('layouts.admin.app')

@section('title', 'Kelola Galeri')
@section('page-title', 'Galeri')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Konten Website</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Galeri</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Galeri Dokumentasi</h1>
            <p class="page-subtitle">Kelola galeri foto dan video kegiatan SMP Sains Al-Qur'an Klakah</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Galeri
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
            <span class="stat-card-label">Total Galeri</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-camera-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Foto & video dokumentasi</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Foto</span>
            <div class="stat-card-icon ic-info"><i class="bi bi-image"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('tipe', 'foto')->count() }}</div>
        <span class="stat-card-link">Galeri gambar</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Video</span>
            <div class="stat-card-icon ic-danger"><i class="bi bi-youtube"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('tipe', 'video')->count() }}</div>
        <span class="stat-card-link">Dokumentasi video</span>
    </div>
</div>

{{-- Table Card --}}
<div class="ac">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-table"></i>
            Daftar Galeri
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} item)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari galeri..." 
                       style="padding-left: 30px; height: 36px; font-size: 0.82rem; min-width: 220px;">
            </div>
            <select id="filterTipe" class="af-select" style="height: 36px; font-size: 0.82rem; min-width: 130px;">
                <option value="">Semua Tipe</option>
                <option value="foto">Foto</option>
                <option value="video">Video</option>
            </select>
        </div>
    </div>

    <div class="ac-body-flush">
        <div class="table-responsive">
            <table class="at" id="tableData">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th style="width: 100px;">Preview</th>
                        <th style="min-width: 200px;">Judul</th>
                        <th style="width: 90px; text-align: center;">Tipe</th>
                        <th>Kategori</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                    <tr class="data-row" data-judul="{{ strtolower($item->judul) }}" data-tipe="{{ $item->tipe }}">
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            @if($item->tipe === 'foto' && $item->file)
                                <img src="{{ asset('storage/'.$item->file) }}" 
                                     alt="{{ $item->judul }}" 
                                     style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px; border: 1.5px solid var(--border);">
                            @elseif($item->tipe === 'video')
                                <div style="width: 70px; height: 50px; border-radius: 8px; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                                    <i class="bi bi-play-circle-fill"></i>
                                </div>
                            @else
                                <div style="width: 70px; height: 50px; border-radius: 8px; background: #f3f4f6; color: var(--text-muted); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $item->judul }}</strong>
                            @if($item->deskripsi)
                                <div style="font-size: 0.78rem; color: var(--text-muted);">{{ Str::limit($item->deskripsi, 60) }}</div>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <span class="badge {{ $item->tipe === 'foto' ? 'badge-info' : 'badge-danger' }}" 
                                  style="font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                                {{ ucfirst($item->tipe) }}
                            </span>
                        </td>
                        <td>
                            {{ $item->kategori ?: '-' }}
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
                                        title="Edit Galeri">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $item->id }}"
                                        title="Hapus Galeri">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.galeri.destroy', $item->id) }}"
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
                        <td colspan="7" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size: 2.2rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                            Belum ada galeri dokumentasi. Klik tombol <strong>Tambah Galeri</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: TAMBAH GALERI ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-plus-circle-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Galeri Baru
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group">
                        <label class="af-label">Judul <span class="req">*</span></label>
                        <input type="text" name="judul" class="af-input" placeholder="e.g. Upacara Hari Santri Nasional" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tipe Media <span class="req">*</span></label>
                        <select name="tipe" id="tipeAdd" class="af-select" required onchange="toggleTipeInput('Add')">
                            <option value="foto">Foto</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="af-group" id="fileGroupAdd">
                        <label class="af-label">File Gambar</label>
                        <input type="file" name="file" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp">
                        <p class="af-hint">Format: JPG, JPEG, PNG, WEBP. Maks 4MB</p>
                    </div>

                    <div class="af-group" id="videoGroupAdd" style="display: none;">
                        <label class="af-label">URL Video (YouTube)</label>
                        <input type="url" name="url_video" class="af-input" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Kategori</label>
                        <input type="text" name="kategori" class="af-input" placeholder="e.g. Kegiatan, Prestasi, Gedung">
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi</label>
                        <textarea name="deskripsi" class="af-textarea" rows="2" placeholder="Keterangan singkat dokumentasi..."></textarea>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan dan tampilkan di galeri depan</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="amodal-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Simpan Galeri
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT GALERI ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Galeri
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
                        <label class="af-label">Judul <span class="req">*</span></label>
                        <input type="text" name="judul" id="edit_judul" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tipe Media <span class="req">*</span></label>
                        <select name="tipe" id="edit_tipe" class="af-select" required onchange="toggleTipeInput('Edit')">
                            <option value="foto">Foto</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="af-group" id="fileGroupEdit">
                        <label class="af-label">Ganti Foto (opsional)</label>
                        <div id="edit_file_preview" class="mb-2"></div>
                        <input type="file" name="file" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp">
                        <p class="af-hint">Format: JPG, JPEG, PNG, WEBP. Kosongkan bila tidak mengganti.</p>
                    </div>

                    <div class="af-group" id="videoGroupEdit" style="display: none;">
                        <label class="af-label">URL Video (YouTube)</label>
                        <input type="url" name="url_video" id="edit_url_video" class="af-input" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Kategori</label>
                        <input type="text" name="kategori" id="edit_kategori" class="af-input">
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="af-textarea" rows="2"></textarea>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan dan tampilkan di galeri depan</span>
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

    function toggleTipeInput(prefix) {
        const tipe = (document.getElementById(prefix === 'Add' ? 'tipeAdd' : 'edit_tipe') || {}).value;
        const fileGroup = document.getElementById('fileGroup' + prefix);
        const videoGroup = document.getElementById('videoGroup' + prefix);

        if (tipe === 'video') {
            if (fileGroup) fileGroup.style.display = 'none';
            if (videoGroup) videoGroup.style.display = 'block';
        } else {
            if (fileGroup) fileGroup.style.display = 'block';
            if (videoGroup) videoGroup.style.display = 'none';
        }
    }

    function openEditModal(item) {
        const form = document.getElementById('editForm');
        form.action = "{{ url('admin/galeri') }}/" + item.id;

        document.getElementById('edit_judul').value = item.judul || '';
        document.getElementById('edit_tipe').value = item.tipe || 'foto';
        document.getElementById('edit_kategori').value = item.kategori || '';
        document.getElementById('edit_deskripsi').value = item.deskripsi || '';
        document.getElementById('edit_url_video').value = item.url_video || '';
        document.getElementById('edit_is_active').checked = !!item.is_active;

        toggleTipeInput('Edit');

        const preview = document.getElementById('edit_file_preview');
        if (item.file) {
            preview.innerHTML = `
                <div class="d-flex align-items-center gap-2" style="background: #f9fafb; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border);">
                    <img src="{{ asset('storage') }}/${item.file}" alt="${item.judul}" 
                         style="width: 60px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border);">
                    <div>
                        <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-primary);">Foto saat ini</div>
                        <div style="font-size: 0.7rem; color: var(--text-muted);">Pilih file baru jika ingin mengganti</div>
                    </div>
                </div>
            `;
        } else {
            preview.innerHTML = `
                <div style="font-size: 0.78rem; color: var(--text-muted); background: #f9fafb; padding: 6px 12px; border-radius: 8px; border: 1px dashed var(--border);">
                    <i class="bi bi-image" style="margin-right: 4px;"></i> Belum ada foto
                </div>
            `;
        }

        openModal('editModal');
    }

    const searchInput = document.getElementById('searchInput');
    const filterTipe = document.getElementById('filterTipe');

    function filterTable() {
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const tipe = (filterTipe ? filterTipe.value : '').toLowerCase().trim();

        document.querySelectorAll('.data-row').forEach(row => {
            const judul = row.getAttribute('data-judul') || '';
            const rowTipe = row.getAttribute('data-tipe') || '';

            const matchQuery = !query || judul.includes(query);
            const matchTipe = !tipe || rowTipe === tipe;

            if (matchQuery && matchTipe) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (filterTipe) filterTipe.addEventListener('change', filterTable);
</script>
@endpush

@endsection
