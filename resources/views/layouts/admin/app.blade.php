<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — SMP Sains Al-Qur'an</title>

    {{-- Favicon --}}
    @php
        $profilAdmin = \App\Models\ProfilSekolah::first();
        $adminFavicon = ($profilAdmin && $profilAdmin->favicon) 
            ? asset('storage/'.$profilAdmin->favicon) 
            : (($profilAdmin && $profilAdmin->logo) 
                ? asset('storage/'.$profilAdmin->logo) 
                : asset('favicon.png'));
    @endphp
    <link rel="icon" type="image/png" href="{{ $adminFavicon }}">
    <link rel="shortcut icon" href="{{ $adminFavicon }}">
    <link rel="apple-touch-icon" href="{{ $adminFavicon }}">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Custom Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    {{-- Page-specific CSS --}}
    @stack('css')

    <style>
        /* Summernote override minimal */
        .note-editor.note-airframe, .note-editor.note-frame {
            border: 1.5px solid #e5e7eb !important;
            border-radius: 10px !important;
        }
    </style>
</head>
<body>
<div class="admin-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="admin-sidebar" id="adminSidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="sidebar-brand-text">
                <div class="sidebar-brand-title">SMP SAQU</div>
                <div class="sidebar-brand-sub">Panel Admin</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            <div class="sidebar-section-label">Utama</div>

            <div class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="sidebar-section-label">Konten Website</div>

            <div class="sidebar-item">
                <a href="{{ route('admin.hero-slider.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.hero-slider*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i>
                    <span>Hero Slider</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.informasi.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.informasi*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper"></i>
                    <span>Berita / Artikel</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.pengumuman.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone"></i>
                    <span>Pengumuman</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.agenda.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.agenda*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i>
                    <span>Agenda</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.galeri.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.galeri*') ? 'active' : '' }}">
                    <i class="bi bi-camera"></i>
                    <span>Galeri</span>
                </a>
            </div>

            <div class="sidebar-section-label">Akademik</div>

            <div class="sidebar-item">
                <a href="{{ route('admin.siswa.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.siswa*') ? 'active' : '' }}">
                    <i class="bi bi-mortarboard"></i>
                    <span>Manajemen Siswa</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.raport.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.raport*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <span>Raport Siswa</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.tenaga-pendidik.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.tenaga-pendidik*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Guru & Staf</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.ekstrakulikuler.crud') }}"
                   class="sidebar-link {{ request()->routeIs('admin.ekstrakulikuler*') ? 'active' : '' }}">
                    <i class="bi bi-trophy"></i>
                    <span>Ekstrakurikuler</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.program-unggulan.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.program-unggulan*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span>Program Unggulan</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.fasilitas.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.fasilitas*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Fasilitas</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('admin.prestasi.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.prestasi*') ? 'active' : '' }}">
                    <i class="bi bi-award"></i>
                    <span>Prestasi</span>
                </a>
            </div>

            <div class="sidebar-section-label">Layanan Masyarakat</div>

            <div class="sidebar-item">
                <a href="{{ route('admin.pengaduan.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.pengaduan*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Pengaduan</span>
                </a>
            </div>

            <div class="sidebar-section-label">Pengaturan</div>

            <div class="sidebar-item">
                <a href="{{ route('admin.profil-sekolah.edit') }}"
                   class="sidebar-link {{ request()->routeIs('admin.profil-sekolah*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>Profil Sekolah</span>
                </a>
            </div>

            <div class="sidebar-item" style="margin-top: 6px;">
                <a href="{{ url('/') }}" target="_blank" class="sidebar-link">
                    <i class="bi bi-globe"></i>
                    <span>Lihat Website</span>
                </a>
            </div>

        </nav>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-footer-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- ── MAIN ── --}}
    <div class="admin-main">

        {{-- Topbar --}}
        <header class="admin-topbar">
            <button class="topbar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="bi bi-list" style="font-size: 1.2rem;"></i>
            </button>

            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>

            <div class="topbar-search">
                <i class="bi bi-search topbar-search-icon"></i>
                <input type="text" placeholder="Cari atau ketik...">
            </div>

            <div class="topbar-actions">
                {{-- Notifications --}}
                <button class="topbar-icon-btn" title="Notifikasi">
                    <i class="bi bi-bell"></i>
                    {{-- @if(($notifCount ?? 0) > 0)
                        <span class="topbar-badge"></span>
                    @endif --}}
                </button>

                {{-- User Dropdown --}}
                <div style="position: relative;">
                    <button class="topbar-user" id="userMenuBtn" aria-label="User Menu">
                        <div class="topbar-avatar">
                            {{ strtoupper(substr(session('nama', 'A'), 0, 2)) }}
                        </div>
                        <div class="topbar-user-info">
                            <span class="topbar-user-name">{{ session('nama') ?? 'Admin' }}</span>
                            <span class="topbar-user-role">Admin</span>
                        </div>
                        <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: #9ca3af; margin-left: 2px;"></i>
                    </button>

                    <div class="topbar-dropdown" id="userDropdown">
                        <div class="topbar-dropdown-header">{{ session('nama') ?? 'Admin' }}</div>
                        <a href="{{ url('/') }}" target="_blank" class="topbar-dropdown-item">
                            <i class="bi bi-globe"></i> Lihat Website
                        </a>
                        <div class="topbar-dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="topbar-dropdown-item danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="admin-content">
            @yield('content')
        </main>

    </div>
</div>

{{-- jQuery (diperlukan untuk halaman yang pakai plugin lama) --}}
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
{{-- Bootstrap 4 JS minimal untuk modal compat --}}
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>

{{-- Admin Panel JS --}}
<script>
    // Sidebar toggle (mobile)
    const sidebar    = document.getElementById('adminSidebar');
    const overlay    = document.getElementById('sidebarOverlay');
    const toggleBtn  = document.getElementById('sidebarToggle');

    function openSidebar()  { sidebar.classList.add('open'); overlay.classList.add('show'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('show'); }

    if (toggleBtn)  toggleBtn.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
    if (overlay)    overlay.addEventListener('click', closeSidebar);

    // User dropdown
    const userBtn  = document.getElementById('userMenuBtn');
    const dropdown = document.getElementById('userDropdown');

    if (userBtn) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        });
        document.addEventListener('click', () => dropdown.classList.remove('show'));
    }

    // Auto dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);
</script>

{{-- Page-specific scripts --}}
@stack('scripts')

</body>
</html>
