@extends('layouts.admin.app')

@section('title', 'Berita & Artikel')
@section('page-title', 'Berita & Artikel')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Konten Website</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Berita & Artikel</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Berita & Artikel</h1>
            <p class="page-subtitle">Kelola publikasi berita kegiatan dan artikel prestasi sekolah</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Berita / Artikel
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
            <span class="stat-card-label">Total Artikel</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-newspaper"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Semua publikasi</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Kategori Berita</span>
            <div class="stat-card-icon ic-info"><i class="bi bi-card-text"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('kategori', 'berita')->count() }}</div>
        <span class="stat-card-link">Berita seputar sekolah</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Kategori Prestasi</span>
            <div class="stat-card-icon ic-success"><i class="bi bi-award-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('kategori', 'prestasi')->count() }}</div>
        <span class="stat-card-link">Pencapaian siswa & sekolah</span>
    </div>
</div>

{{-- Table Card --}}
<div class="ac">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-table"></i>
            Daftar Berita & Artikel
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} artikel)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari judul..." 
                       style="padding-left: 30px; height: 36px; font-size: 0.82rem; min-width: 220px;">
            </div>
            <select id="filterKategori" class="af-select" style="height: 36px; font-size: 0.82rem; min-width: 140px;">
                <option value="">Semua Kategori</option>
                <option value="berita">Berita</option>
                <option value="prestasi">Prestasi</option>
            </select>
        </div>
    </div>

    <div class="ac-body-flush">
        <div class="table-responsive">
            <table class="at" id="tableData">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th style="width: 100px;">Gambar</th>
                        <th style="min-width: 200px;">Judul</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $i => $row)
                    <tr class="data-row" data-judul="{{ strtolower($row->judul) }}" data-kategori="{{ strtolower($row->kategori) }}">
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            @if($row->gambar)
                                <img src="{{ asset('storage/'.$row->gambar) }}" 
                                     alt="{{ $row->judul }}" 
                                     style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px; border: 1.5px solid var(--border);">
                            @else
                                <div style="width: 70px; height: 50px; border-radius: 8px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.2rem; border: 1px dashed var(--border);">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $row->judul }}</strong>
                        </td>
                        <td>
                            <span class="badge {{ $row->kategori === 'berita' ? 'badge-primary' : 'badge-success' }}" 
                                  style="font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                                {{ ucfirst($row->kategori) }}
                            </span>
                        </td>
                        <td>
                            <div style="color: var(--text-secondary); font-size: 0.84rem; line-height: 1.5; max-width: 450px;">
                                {{ Str::limit(strip_tags($row->deskripsi_berita), 110) ?: '-' }}
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-inline-flex gap-1">
                                {{-- Tombol Edit --}}
                                <button type="button" class="ab ab-sm ab-secondary" 
                                        onclick="openEditModal({{ json_encode($row) }})"
                                        title="Edit Artikel">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $row->id }}"
                                        title="Hapus Artikel">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $row->id }}" 
                                      action="{{ route('admin.informasi.destroy', $row->id) }}"
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
                            Belum ada artikel yang ditambahkan. Klik tombol <strong>Tambah Berita / Artikel</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: TAMBAH INFORMASI ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-plus-circle-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Berita / Artikel
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="af-group">
                    <label class="af-label">Judul Artikel <span class="req">*</span></label>
                    <input type="text" name="judul" class="af-input" placeholder="Masukkan judul berita atau artikel..." required>
                </div>

                <div class="ag ag-2">
                    <div class="af-group">
                        <label class="af-label">Kategori <span class="req">*</span></label>
                        <select name="kategori" class="af-select" required>
                            <option value="berita">Berita</option>
                            <option value="prestasi">Prestasi</option>
                        </select>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Gambar Sampul (opsional)</label>
                        <input type="file" name="gambar" class="af-file" accept="image/png, image/jpeg, image/jpg">
                        <p class="af-hint">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                    </div>
                </div>

                <div class="af-group">
                    <label class="af-label">Isi / Deskripsi Berita <span class="req">*</span></label>
                    <textarea name="deskripsi_berita" class="af-textarea" rows="6" placeholder="Tuliskan isi berita atau artikel secara lengkap..." required></textarea>
                </div>
            </div>
            <div class="amodal-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT INFORMASI ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Berita / Artikel
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('editModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="amodal-body">
                <div class="af-group">
                    <label class="af-label">Judul Artikel <span class="req">*</span></label>
                    <input type="text" name="judul" id="edit_judul" class="af-input" required>
                </div>

                <div class="ag ag-2">
                    <div class="af-group">
                        <label class="af-label">Kategori <span class="req">*</span></label>
                        <select name="kategori" id="edit_kategori" class="af-select" required>
                            <option value="berita">Berita</option>
                            <option value="prestasi">Prestasi</option>
                        </select>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Ganti Gambar (opsional)</label>
                        <div id="edit_gambar_preview" class="mb-2"></div>
                        <input type="file" name="gambar" class="af-file" accept="image/png, image/jpeg, image/jpg">
                        <p class="af-hint">Format: JPG, JPEG, PNG. Kosongkan jika tidak ingin mengganti gambar.</p>
                    </div>
                </div>

                <div class="af-group">
                    <label class="af-label">Isi / Deskripsi Berita <span class="req">*</span></label>
                    <textarea name="deskripsi_berita" id="edit_deskripsi_berita" class="af-textarea" rows="6" required></textarea>
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
        const form = document.getElementById('editForm');
        form.action = "{{ url('admin/informasi') }}/" + row.id;

        document.getElementById('edit_judul').value = row.judul || '';
        document.getElementById('edit_kategori').value = row.kategori || 'berita';
        document.getElementById('edit_deskripsi_berita').value = row.deskripsi_berita || '';

        const preview = document.getElementById('edit_gambar_preview');
        if (row.gambar) {
            preview.innerHTML = `
                <div class="d-flex align-items-center gap-2" style="background: #f9fafb; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border);">
                    <img src="{{ asset('storage') }}/${row.gambar}" alt="${row.judul}" 
                         style="width: 60px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border);">
                    <div>
                        <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-primary);">Gambar saat ini</div>
                        <div style="font-size: 0.7rem; color: var(--text-muted);">Pilih file baru jika ingin mengganti</div>
                    </div>
                </div>
            `;
        } else {
            preview.innerHTML = `
                <div style="font-size: 0.78rem; color: var(--text-muted); background: #f9fafb; padding: 6px 12px; border-radius: 8px; border: 1px dashed var(--border);">
                    <i class="bi bi-image" style="margin-right: 4px;"></i> Belum ada gambar
                </div>
            `;
        }

        openModal('editModal');
    }

    // ── Table Search & Filter ──
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');

    function filterTable() {
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const kat = (filterKategori ? filterKategori.value : '').toLowerCase().trim();

        document.querySelectorAll('.data-row').forEach(row => {
            const judul = row.getAttribute('data-judul') || '';
            const rowKat = row.getAttribute('data-kategori') || '';

            const matchQuery = !query || judul.includes(query);
            const matchKat = !kat || rowKat === kat;

            if (matchQuery && matchKat) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (filterKategori) filterKategori.addEventListener('change', filterTable);
</script>
@endpush

@endsection
