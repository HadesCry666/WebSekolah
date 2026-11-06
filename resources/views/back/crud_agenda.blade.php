@extends('layouts.admin.app')

@section('title', 'Agenda & Kegiatan')
@section('page-title', 'Agenda')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Konten Website</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Agenda</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Agenda & Kegiatan</h1>
            <p class="page-subtitle">Kelola kalender kegiatan dan jadwal acara sekolah</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="ab ab-primary" onclick="openModal('addModal')">
                <i class="bi bi-plus-lg"></i> Tambah Agenda
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
            <span class="stat-card-label">Total Agenda</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-calendar-event-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Semua agenda acara</span>
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
            Daftar Agenda
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} agenda)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari judul / lokasi..." 
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
                        <th style="min-width: 200px;">Judul Agenda</th>
                        <th>Jadwal Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                    <tr class="data-row" data-judul="{{ strtolower($item->judul) }}" data-lokasi="{{ strtolower($item->lokasi ?? '') }}">
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $item->judul }}</strong>
                            @if($item->deskripsi)
                                <div style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.4; max-width: 400px;">{{ Str::limit($item->deskripsi, 80) }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.84rem; font-weight: 600; color: var(--text-primary);">
                                <i class="bi bi-calendar3 me-1 text-primary"></i>
                                {{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d M Y') : '-' }}
                                @if($item->tanggal_selesai && $item->tanggal_selesai != $item->tanggal_mulai)
                                    s/d {{ $item->tanggal_selesai->format('d M Y') }}
                                @endif
                            </div>
                            @if($item->waktu_mulai)
                                <div style="font-size: 0.75rem; color: var(--text-muted);"><i class="bi bi-clock me-1"></i>{{ $item->waktu_mulai }} WIB</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.84rem; color: var(--text-secondary);">
                                <i class="bi bi-geo-alt me-1 text-danger"></i>{{ $item->lokasi ?: '-' }}
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
                                        title="Edit Agenda">
                                    <i class="bi bi-pencil-fill" style="color: var(--primary);"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $item->id }}"
                                        title="Hapus Agenda">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.agenda.destroy', $item->id) }}"
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
                            Belum ada agenda kegiatan. Klik tombol <strong>Tambah Agenda</strong> untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: TAMBAH AGENDA ================= --}}
<div class="amodal-backdrop" id="addModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-plus-circle-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Tambah Agenda Baru
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('addModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form action="{{ route('admin.agenda.store') }}" method="POST">
            @csrf
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Judul Agenda <span class="req">*</span></label>
                        <input type="text" name="judul" class="af-input" placeholder="e.g. Ujian Tengah Semester Ganjil" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="tanggal_mulai" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Selesai (opsional)</label>
                        <input type="date" name="tanggal_selesai" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Lokasi</label>
                        <input type="text" name="lokasi" class="af-input" placeholder="e.g. Aula Sekolah / Lapangan Utama">
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi Agenda</label>
                        <textarea name="deskripsi" class="af-textarea" rows="3" placeholder="Penjelasan atau detail acara..."></textarea>
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
                    <i class="bi bi-check-lg"></i> Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT AGENDA ================= --}}
<div class="amodal-backdrop" id="editModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-pencil-fill" style="color: var(--warning); margin-right: 6px;"></i>
                Edit Agenda
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('editModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="amodal-body">
                <div class="ag ag-2">
                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Judul Agenda <span class="req">*</span></label>
                        <input type="text" name="judul" id="edit_judul" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="af-input" required>
                    </div>

                    <div class="af-group">
                        <label class="af-label">Tanggal Selesai (opsional)</label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" id="edit_waktu_mulai" class="af-input">
                    </div>

                    <div class="af-group">
                        <label class="af-label">Lokasi</label>
                        <input type="text" name="lokasi" id="edit_lokasi" class="af-input">
                    </div>

                    <div class="af-group" style="grid-column: 1 / -1;">
                        <label class="af-label">Deskripsi Agenda</label>
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
        form.action = "{{ url('admin/agenda') }}/" + item.id;

        document.getElementById('edit_judul').value = item.judul || '';
        document.getElementById('edit_tanggal_mulai').value = item.tanggal_mulai ? item.tanggal_mulai.substring(0, 10) : '';
        document.getElementById('edit_tanggal_selesai').value = item.tanggal_selesai ? item.tanggal_selesai.substring(0, 10) : '';
        document.getElementById('edit_waktu_mulai').value = item.waktu_mulai || '';
        document.getElementById('edit_lokasi').value = item.lokasi || '';
        document.getElementById('edit_deskripsi').value = item.deskripsi || '';
        document.getElementById('edit_is_active').checked = !!item.is_active;

        openModal('editModal');
    }

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.data-row').forEach(row => {
                const judul = row.getAttribute('data-judul') || '';
                const lokasi = row.getAttribute('data-lokasi') || '';
                if (!query || judul.includes(query) || lokasi.includes(query)) {
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
