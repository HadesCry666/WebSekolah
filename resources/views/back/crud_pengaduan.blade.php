@extends('layouts.admin.app')

@section('title', 'Pengaduan Masyarakat')
@section('page-title', 'Pengaduan')

@section('content')

{{-- Breadcrumb & Header --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Layanan Masyarakat</span>
        <span class="page-breadcrumb-sep">/</span>
        <span>Pengaduan</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Pengaduan Masyarakat</h1>
            <p class="page-subtitle">Kelola pesan saran, kritik, dan aspirasi masyarakat untuk sekolah</p>
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

{{-- Stat Cards --}}
<div class="stat-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Total Pengaduan</span>
            <div class="stat-card-icon ic-primary"><i class="bi bi-chat-dots-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->count() }}</div>
        <span class="stat-card-link">Semua aspirasi masuk</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Pengaduan Baru</span>
            <div class="stat-card-icon ic-danger"><i class="bi bi-bell-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('status', 'baru')->count() }}</div>
        <span class="stat-card-link">Perlu ditinjau</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Sedang Diproses</span>
            <div class="stat-card-icon ic-warning"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('status', 'proses')->count() }}</div>
        <span class="stat-card-link">Tindak lanjut</span>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Telah Selesai</span>
            <div class="stat-card-icon ic-success"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="stat-card-value">{{ $data->where('status', 'selesai')->count() }}</div>
        <span class="stat-card-link">Selesai ditangani</span>
    </div>
</div>

{{-- Table Card --}}
<div class="ac">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-table"></i>
            Daftar Pesan Pengaduan
            <span style="font-size: 0.78rem; font-weight: 500; color: var(--text-muted); margin-left: 6px;">
                ({{ $data->count() }} pesan)
            </span>
        </span>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div style="position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="af-input" placeholder="Cari nama / judul..." 
                       style="padding-left: 30px; height: 36px; font-size: 0.82rem; min-width: 220px;">
            </div>
            <select id="filterStatus" class="af-select" style="height: 36px; font-size: 0.82rem; min-width: 140px;">
                <option value="">Semua Status</option>
                <option value="baru">Baru</option>
                <option value="proses">Proses</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
    </div>

    <div class="ac-body-flush">
        <div class="table-responsive">
            <table class="at" id="tableData">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th style="min-width: 180px;">Pengirim</th>
                        <th>Kontak</th>
                        <th>Judul & Isi Pengaduan</th>
                        <th>Tanggal</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $item)
                    <tr class="data-row" data-nama="{{ strtolower($item->nama) }}" data-judul="{{ strtolower($item->judul) }}" data-status="{{ $item->status ?? 'baru' }}">
                        <td style="text-align: center; color: var(--text-muted); font-size: 0.8rem;">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.88rem;">{{ $item->nama }}</strong>
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                @if($item->email)
                                    <div><i class="bi bi-envelope me-1"></i>{{ $item->email }}</div>
                                @endif
                                @if($item->no_hp)
                                    <div><i class="bi bi-telephone me-1"></i>{{ $item->no_hp }}</div>
                                @endif
                                @if(!$item->email && !$item->no_hp)
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.85rem; display: block;">{{ $item->judul }}</strong>
                            <div style="color: var(--text-muted); font-size: 0.8rem; line-height: 1.4; max-width: 400px;">
                                {{ Str::limit($item->isi, 75) }}
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 0.8rem; color: var(--text-secondary);">
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            @php
                                $statusBadge = match($item->status ?? 'baru') {
                                    'baru' => 'badge-danger',
                                    'proses' => 'badge-warning',
                                    'selesai' => 'badge-success',
                                    default => 'badge-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusBadge }}" style="font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                                {{ ucfirst($item->status ?? 'Baru') }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-inline-flex gap-1">
                                {{-- Tombol Detail --}}
                                <button type="button" class="ab ab-sm ab-outline" 
                                        onclick="openDetailModal({{ json_encode($item) }})"
                                        title="Lihat Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="ab ab-sm ab-danger btn-delete" 
                                        data-id="{{ $item->id }}"
                                        title="Hapus Pengaduan">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.pengaduan.destroy', $item->id) }}"
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
                            Belum ada pesan pengaduan yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= MODAL: DETAIL PENGADUAN ================= --}}
<div class="amodal-backdrop" id="detailModal">
    <div class="amodal amodal-lg">
        <div class="amodal-header">
            <span class="amodal-title">
                <i class="bi bi-chat-quote-fill" style="color: var(--primary); margin-right: 6px;"></i>
                Detail Pengaduan
            </span>
            <button type="button" class="amodal-close" onclick="closeModal('detailModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="amodal-body">
            <div style="background: #f9fafb; border: 1px solid var(--border); border-radius: 12px; padding: 18px; margin-bottom: 20px;">
                <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                    <div>
                        <h4 id="detail_judul" style="font-size: 1.05rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;"></h4>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">
                            Dikirim oleh <strong id="detail_nama" style="color: var(--text-primary);"></strong> pada <span id="detail_tanggal"></span>
                        </div>
                    </div>
                    <div id="detail_status_badge"></div>
                </div>

                <div class="ag ag-2 mb-3" style="font-size: 0.84rem;">
                    <div><span class="text-muted">Email:</span> <strong id="detail_email"></strong></div>
                    <div><span class="text-muted">No. WhatsApp / HP:</span> <strong id="detail_no_hp"></strong></div>
                </div>

                <div>
                    <label class="af-label" style="font-size: 0.75rem; text-transform: uppercase;">Isi Pesan Pengaduan:</label>
                    <div id="detail_isi" style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6; background: #fff; padding: 14px; border-radius: 8px; border: 1px solid var(--border); white-space: pre-wrap;"></div>
                </div>
            </div>

            {{-- Form Update Status --}}
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background: #f3f4f6;">
                    <div class="d-flex align-items-center gap-2">
                        <label class="af-label mb-0" style="white-space: nowrap;">Ubah Status:</label>
                        <select name="status" id="detail_status_select" class="af-select" style="min-width: 140px; height: 36px;">
                            <option value="baru">Baru</option>
                            <option value="proses">Sedang Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <button type="submit" class="ab ab-primary" style="height: 36px;">
                        <i class="bi bi-check-lg"></i> Perbarui Status
                    </button>
                </div>
            </form>
        </div>
        <div class="amodal-footer">
            <button type="button" class="ab ab-secondary" onclick="closeModal('detailModal')">Tutup</button>
        </div>
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

    function openDetailModal(item) {
        document.getElementById('detail_judul').textContent = item.judul || '';
        document.getElementById('detail_nama').textContent = item.nama || '';
        document.getElementById('detail_email').textContent = item.email || '-';
        document.getElementById('detail_no_hp').textContent = item.no_hp || '-';
        document.getElementById('detail_isi').textContent = item.isi || '';
        document.getElementById('detail_tanggal').textContent = item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';

        const status = item.status || 'baru';
        document.getElementById('detail_status_select').value = status;

        const badgeEl = document.getElementById('detail_status_badge');
        let badgeClass = 'badge-secondary';
        let badgeText = status.toUpperCase();
        if (status === 'baru') { badgeClass = 'badge-danger'; badgeText = 'BARU'; }
        else if (status === 'proses') { badgeClass = 'badge-warning'; badgeText = 'PROSES'; }
        else if (status === 'selesai') { badgeClass = 'badge-success'; badgeText = 'SELESAI'; }

        badgeEl.innerHTML = `<span class="badge ${badgeClass}" style="font-size: 0.78rem; padding: 5px 12px; border-radius: 6px;">${badgeText}</span>`;

        const form = document.getElementById('statusForm');
        form.action = "{{ url('admin/pengaduan') }}/" + item.id + "/status";

        openModal('detailModal');
    }

    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');

    function filterTable() {
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const status = (filterStatus ? filterStatus.value : '').toLowerCase().trim();

        document.querySelectorAll('.data-row').forEach(row => {
            const nama = row.getAttribute('data-nama') || '';
            const judul = row.getAttribute('data-judul') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchQuery = !query || nama.includes(query) || judul.includes(query);
            const matchStatus = !status || rowStatus === status;

            if (matchQuery && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (filterStatus) filterStatus.addEventListener('change', filterTable);
</script>
@endpush

@endsection
