@extends('layouts.admin.app')

@section('title', 'Dashboard — Admin SMP Sains Al-Qur\'an')
@section('page-title', 'Dasbor')

@section('content')

{{-- Breadcrumb --}}
<div class="page-header">
    <div class="page-breadcrumb">
        <i class="bi bi-house-fill"></i>
        <span class="page-breadcrumb-sep">/</span>
        <span>Dashboard</span>
    </div>
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Ringkasan Sistem</h1>
            <p class="page-subtitle">Selamat datang kembali, <strong>{{ session('nama') ?? 'Admin' }}</strong>. Kelola konten website sekolah dari sini.</p>
        </div>
        <a href="{{ route('admin.profil-sekolah.edit') }}" class="ab ab-outline" style="gap: 7px;">
            <i class="bi bi-gear"></i> Pengaturan
        </a>
    </div>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- ── STAT CARDS ── --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Berita & Artikel</span>
            <div class="stat-card-icon ic-primary">
                <i class="bi bi-newspaper"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['artikel'] ?? 0 }}</div>
        <a href="{{ route('admin.informasi.index') }}" class="stat-card-link">
            Kelola <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Guru & Staf</span>
            <div class="stat-card-icon ic-success">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['guru'] ?? 0 }}</div>
        <a href="{{ route('admin.tenaga-pendidik.index') }}" class="stat-card-link">
            Kelola <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Prestasi</span>
            <div class="stat-card-icon ic-warning">
                <i class="bi bi-award-fill"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['prestasi'] ?? 0 }}</div>
        <a href="{{ route('admin.prestasi.index') }}" class="stat-card-link">
            Kelola <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Pengaduan Baru</span>
            <div class="stat-card-icon ic-danger">
                <i class="bi bi-chat-dots-fill"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['pengaduan_baru'] ?? 0 }}</div>
        <a href="{{ route('admin.pengaduan.index') }}" class="stat-card-link">
            Lihat <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Galeri</span>
            <div class="stat-card-icon ic-info">
                <i class="bi bi-images"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['galeri'] ?? 0 }}</div>
        <a href="{{ route('admin.galeri.index') }}" class="stat-card-link">
            Kelola <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Agenda</span>
            <div class="stat-card-icon" style="background:#fdf4ff; color: #a855f7;">
                <i class="bi bi-calendar-event-fill"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['agenda'] ?? 0 }}</div>
        <a href="{{ route('admin.agenda.index') }}" class="stat-card-link">
            Kelola <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Pengumuman</span>
            <div class="stat-card-icon ic-success">
                <i class="bi bi-megaphone-fill"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['pengumuman'] ?? 0 }}</div>
        <a href="{{ route('admin.pengumuman.index') }}" class="stat-card-link">
            Kelola <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <span class="stat-card-label">Program Unggulan</span>
            <div class="stat-card-icon ic-warning">
                <i class="bi bi-star-fill"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['program'] ?? 0 }}</div>
        <a href="{{ route('admin.program-unggulan.index') }}" class="stat-card-link">
            Kelola <i class="bi bi-arrow-right"></i>
        </a>
    </div>

</div>

{{-- ── TABLES SECTION ── --}}
<div class="ag ag-2" style="margin-top:4px;">

    {{-- Artikel Terbaru --}}
    <div class="ac">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-newspaper"></i> Artikel Terbaru
            </span>
            <a href="{{ route('admin.informasi.index') }}" class="ab ab-sm ab-outline">
                Lihat Semua
            </a>
        </div>
        <div class="ac-body ac-body-flush">
            <table class="at">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artikelTerbaru as $item)
                    <tr>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Str::limit($item->judul, 40) }}
                        </td>
                        <td>
                            <span class="badge {{ $item->kategori == 'berita' ? 'badge-info' : 'badge-warning' }}">
                                {{ ucfirst($item->kategori) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted" style="padding: 28px 0;">
                            <i class="bi bi-inbox" style="font-size:1.5rem; display:block; margin-bottom:6px; opacity:0.4;"></i>
                            Belum ada artikel.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pengaduan Terbaru --}}
    <div class="ac">
        <div class="ac-header">
            <span class="ac-title">
                <i class="bi bi-chat-dots"></i> Pengaduan Terbaru
            </span>
            <a href="{{ route('admin.pengaduan.index') }}" class="ab ab-sm ab-outline" style="color: var(--danger); border-color: var(--danger);">
                Lihat Semua
            </a>
        </div>
        <div class="ac-body ac-body-flush">
            <table class="at">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Judul</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduanBaru as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ Str::limit($item->judul, 28) }}</td>
                        <td>
                            @php
                                $cls = match($item->status ?? 'baru') {
                                    'baru'    => 'badge-danger',
                                    'proses'  => 'badge-warning',
                                    'selesai' => 'badge-success',
                                    default   => 'badge-gray'
                                };
                            @endphp
                            <span class="badge {{ $cls }}">{{ ucfirst($item->status ?? 'baru') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted" style="padding: 28px 0;">
                            <i class="bi bi-check2-circle" style="font-size:1.5rem; display:block; margin-bottom:6px; color: var(--success); opacity:0.6;"></i>
                            Tidak ada pengaduan baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Agenda Mendatang --}}
<div class="ac" style="margin-top: 0;">
    <div class="ac-header">
        <span class="ac-title">
            <i class="bi bi-calendar-event"></i> Agenda Mendatang
        </span>
        <a href="{{ route('admin.agenda.index') }}" class="ab ab-sm ab-outline" style="color: var(--info); border-color: var(--info);">
            Lihat Semua
        </a>
    </div>
    <div class="ac-body ac-body-flush">
        <table class="at">
            <thead>
                <tr>
                    <th>Judul Agenda</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agendaMendatang as $item)
                <tr>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->tanggal_mulai->format('d M Y') }}</td>
                    <td>{{ $item->lokasi ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted" style="padding: 28px 0;">
                        <i class="bi bi-calendar-x" style="font-size:1.5rem; display:block; margin-bottom:6px; opacity:0.4;"></i>
                        Tidak ada agenda mendatang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
