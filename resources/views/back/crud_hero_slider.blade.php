@extends('layouts.admin.app')

@section('title', 'Hero Slider')
@section('page-title', 'Hero Slider')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Konten Website</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Hero Slider</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Hero Slider Beranda</h1>
            <p class="page-subtitle">Kelola slide banner utama dan pesan promosi di halaman beranda</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Slider
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
            <span class="stat-card-label">Total Slider</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-images"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Banner tersimpan</span>
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
            Daftar Slider
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} slide)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari slider..." 
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
                        <th style="width: 110px;">Banner</th>
                        <th style="min-width: 200px;">Judul & Deskripsi</th>
                        <th>Badge & Tombol</th>
                        <th style="width: 80px; text-align: center;">Urutan</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                    <tr class="data-row" data-judul="{{ strtolower($item->judul ?? '') }}">
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" 
                                     alt="{{ $item->judul }}" 
                                     style="width: 90px; height: 50px; object-fit: cover; border-radius: 8px; border: 1.5px solid var(--border);">
                            @else
                                <div style="width: 90px; height: 50px; border-radius: 8px; background: #f3f4f6; color: var(--text-muted); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $item->judul ?: '(Tanpa judul)' }}</strong>
                            @if($item->deskripsi)
                                <div style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.4; max-width: 450px;">{{ Str::limit($item->deskripsi, 90) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($item->badge_teks)
                                <span class="badge badge-info mb-1 d-inline-block">{{ $item->badge_teks }}</span><br>
                            @endif
                            @if($item->tombol_teks)
                                <span style="font-size: 0.78rem; color: var(--text-secondary);"><i class="bi bi-box-arrow-up-right me-1"></i>{{ $item->tombol_teks }}</span>
                            @else
                                <span class="text-muted" style="font-size: 0.8rem;">-</span>
                            @endif
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
                                        title="Edit Slider">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $item->id }}"
                                        title="Hapus Slider">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.hero-slider.destroy', $item->id) }}"
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
                            Belum ada slider. Klik tombol <strong>Tambah Slider</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: TAMBAH SLIDER ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-plus-circle-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Slider Baru
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.hero-slider.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Gambar Slider <span class="req">*</span></label>
                        <input type="file" name="gambar" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp" required>
                        <p class="af-hint">Rekomendasi ukuran: 1920x800 px. Format: JPG, PNG, WEBP. Maks 4MB</p>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Judul Slider</label>
                        <input type="text" name="judul" class="af-input" placeholder="e.g. Selamat Datang di SMP SAQU">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Badge Text (Label Kecil di Atas)</label>
                        <input type="text" name="badge_teks" class="af-input" placeholder="e.g. PPDB Online / Penerimaan Baru">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Teks Tombol Aksi</label>
                        <input type="text" name="tombol_teks" class="af-input" placeholder="e.g. Profil Sekolah / Selengkapnya">
                    </div>

                    <div class="af-group">
                        <label class="af-label">URL Tombol Aksi</label>
                        <input type="text" name="tombol_url" class="af-input" placeholder="e.g. /profil-sekolah atau /kurikulum">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Urutan Tampil</label>
                        <input type="number" name="urutan" class="af-input" value="0">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Status Tampil</label>
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer; margin-top: 8px;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan slide</span>
                        </label>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi</label>
                        <textarea name="deskripsi" class="af-textarea" rows="2" placeholder="Subjudul atau penjelasan singkat slide..."></textarea>
                    </div>
                </div>
            </div>
            <div class="amodal-footer">
                <button type="button" class="ab ab-secondary" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="ab ab-primary">
                    <i class="bi bi-check-lg"></i> Simpan Slider
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT SLIDER ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Slider
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
                        <label class="af-label">Ganti Gambar (opsional)</label>
                        <div id="edit_gambar_preview" class="mb-2"></div>
                        <input type="file" name="gambar" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp">
                        <p class="af-hint">Kosongkan bila tidak mengganti gambar.</p>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Judul Slider</label>
                        <input type="text" name="judul" id="edit_judul" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Badge Text</label>
                        <input type="text" name="badge_teks" id="edit_badge_teks" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Teks Tombol Aksi</label>
                        <input type="text" name="tombol_teks" id="edit_tombol_teks" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">URL Tombol Aksi</label>
                        <input type="text" name="tombol_url" id="edit_tombol_url" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Urutan Tampil</label>
                        <input type="number" name="urutan" id="edit_urutan" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Status Tampil</label>
                        <label class="af-check d-flex align-items-center gap-2" style="cursor: pointer; margin-top: 8px;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="width: 18px; height: 18px;">
                            <span style="font-size: 0.88rem; font-weight: 500;">Aktifkan slide</span>
                        </label>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="af-textarea" rows="2"></textarea>
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
        form.action = "{{ url('admin/hero-slider') }}/" + item.id;

        document.getElementById('edit_judul').value = item.judul || '';
        document.getElementById('edit_badge_teks').value = item.badge_teks || '';
        document.getElementById('edit_tombol_teks').value = item.tombol_teks || '';
        document.getElementById('edit_tombol_url').value = item.tombol_url || '';
        document.getElementById('edit_urutan').value = item.urutan ?? 0;
        document.getElementById('edit_deskripsi').value = item.deskripsi || '';
        document.getElementById('edit_is_active').checked = !!item.is_active;

        const preview = document.getElementById('edit_gambar_preview');
        if (item.gambar) {
            preview.innerHTML = `
                <div class="d-flex align-items-center gap-2" style="background: #f9fafb; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border);">
                    <img src="{{ asset('storage') }}/${item.gambar}" alt="${item.judul}" 
                         style="width: 80px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border);">
                    <div>
                        <div style="font-size: 0.78rem; font-weight: 600; color: var(--text-primary);">Banner saat ini</div>
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
