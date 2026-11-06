@extends('layouts.admin.app')

@section('title', 'Kelola Prestasi')
@section('page-title', 'Prestasi')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Akademik</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Prestasi</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Prestasi Siswa & Sekolah</h1>
            <p class="page-subtitle">Kelola catatan prestasi akademik, non-akademik, dan kejuaraan tahfidz</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Prestasi
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
            <span class="stat-card-label">Total Prestasi</span>
            <div class="stat-card-icon ic-warning"><i class="bi bi-award-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Pencapaian kejuaraan</span>
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
            Daftar Prestasi
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} prestasi)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari prestasi..." 
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
                        <th style="width: 90px;">Foto</th>
                        <th style="min-width: 200px;">Nama Prestasi / Juara</th>
                        <th>Kategori & Tingkat</th>
                        <th>Tanggal</th>
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
                            @if($item->foto)
                                <img src="{{ asset('storage/'.$item->foto) }}" 
                                     alt="{{ $item->nama }}" 
                                     style="width: 65px; height: 48px; object-fit: cover; border-radius: 8px; border: 1.5px solid var(--border);">
                            @else
                                <div style="width: 65px; height: 48px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                    <i class="bi bi-award"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $item->nama }}</strong>
                            @if($item->deskripsi)
                                <div style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.4; max-width: 400px;">{{ Str::limit($item->deskripsi, 80) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($item->kategori)
                                <span class="badge badge-primary me-1">{{ $item->kategori }}</span>
                            @endif
                            @if($item->tingkat)
                                <span class="badge badge-warning">{{ $item->tingkat }}</span>
                            @endif
                            @if(!$item->kategori && !$item->tingkat)
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.84rem; color: var(--text-secondary);">
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}
                            </span>
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
                                        title="Edit Prestasi">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $item->id }}"
                                        title="Hapus Prestasi">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.prestasi.destroy', $item->id) }}"
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
                            Belum ada prestasi yang ditambahkan. Klik tombol <strong>Tambah Prestasi</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: TAMBAH PRESTASI ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-plus-circle-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Prestasi Baru
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Nama Prestasi / Kejuaraan <span class="req">*</span></label>
                        <input type="text" name="nama" class="af-input" placeholder="e.g. Juara 1 MHQ Tingkat Kabupaten Lumajang" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Kategori</label>
                        <input type="text" name="kategori" class="af-input" placeholder="e.g. Akademik, Tahfidz, Olahraga">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tingkat</label>
                        <input type="text" name="tingkat" class="af-input" placeholder="e.g. Kabupaten, Provinsi, Nasional">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Foto / Piagam (opsional)</label>
                        <input type="file" name="foto" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp">
                        <p class="af-hint">Format: JPG, JPEG, PNG, WEBP. Maks 2MB</p>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi / Peraih Prestasi</label>
                        <textarea name="deskripsi" class="af-textarea" rows="3" placeholder="Nama siswa peraih, penyelenggara, atau rincian penghargaan..."></textarea>
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
                    <i class="bi bi-check-lg"></i> Simpan Prestasi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT PRESTASI ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Prestasi
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
                        <label class="af-label">Nama Prestasi / Kejuaraan <span class="req">*</span></label>
                        <input type="text" name="nama" id="edit_nama" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Kategori</label>
                        <input type="text" name="kategori" id="edit_kategori" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tingkat</label>
                        <input type="text" name="tingkat" id="edit_tingkat" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Ganti Foto (opsional)</label>
                        <div id="edit_foto_preview" class="mb-2"></div>
                        <input type="file" name="foto" class="af-file" accept="image/png, image/jpeg, image/jpg, image/webp">
                        <p class="af-hint">Kosongkan bila tidak mengganti foto.</p>
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi / Peraih Prestasi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="af-textarea" rows="3"></textarea>
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
        form.action = "{{ url('admin/prestasi') }}/" + item.id;

        document.getElementById('edit_nama').value = item.nama || '';
        document.getElementById('edit_kategori').value = item.kategori || '';
        document.getElementById('edit_tingkat').value = item.tingkat || '';
        document.getElementById('edit_tanggal').value = item.tanggal ? item.tanggal.substring(0, 10) : '';
        document.getElementById('edit_deskripsi').value = item.deskripsi || '';
        document.getElementById('edit_is_active').checked = !!item.is_active;

        const preview = document.getElementById('edit_foto_preview');
        if (item.foto) {
            preview.innerHTML = `
                <div class="d-flex align-items-center gap-2" style="background: #f9fafb; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border);">
                    <img src="{{ asset('storage') }}/${item.foto}" alt="${item.nama}" 
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
