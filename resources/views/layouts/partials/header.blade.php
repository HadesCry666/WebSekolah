 {{-- ================= HEADER (TOP + NAVBAR) ================= --}}
@php
    $profil = \App\Models\ProfilSekolah::first();
@endphp
        <header>
            {{-- TOP HEADER (Hanya tampil di desktop layar besar) --}}
            <div class="header-top d-none d-lg-block">
                <div class="container d-flex flex-wrap justify-content-between align-items-center">
                    {{-- Logo kiri --}}
                    <div class="logo-wrap d-flex align-items-center gap-2">
                        <img src="{{ ($profil && $profil->logo) ? asset('storage/'.$profil->logo) : asset('storage/mentahan-logo.jpg') }}" alt="Logo SMP" onerror="this.onerror=null;this.src='{{ asset('assets/img/stisla-fill.svg') }}';">
                        <div>
                            <div class="logo-text-title">SMP SAINS AL-QUR'AN</div>
                            <div class="logo-text-title">KLAKAH</div>
                        </div>
                    </div>

                    {{-- Kontak + Sosmed --}}
                    <div class="contact-group d-flex flex-wrap align-items-center gap-3">
                        <div class="contact-item">
                            <div class="contact-icon-circle">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <div class="contact-label">Telepon</div>
                                <div class="contact-value">{{ $profil->telepon ?? '(0334) 881866' }}</div>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon-circle">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <div class="contact-label">Alamat Email</div>
                                <div class="contact-value">{{ $profil->email ?? 'info@smpsainsquran.sch.id' }}</div>
                            </div>
                        </div>

                    <div class="d-flex align-items-center">
                        <div class="social-divider d-none d-lg-block"></div>
                        <div class="social-list">
                            <a href="https://wa.me/{{ $profil->whatsapp ?? '6287612346453' }}" 
                            class="text-success" 
                            target="_blank">
                                <i class="bi bi-whatsapp"></i>
                            </a>

                            <a href="{{ $profil->instagram ?? 'https://www.instagram.com/smpsainsquranklakah/' }}" 
                            class="text-danger" 
                            target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>

                            <a href="{{ $profil->youtube ?? 'https://www.youtube.com/@smpsainsquranklakah' }}" 
                            class="text-danger" 
                            target="_blank">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            {{-- NAVBAR --}}
            <nav class="navbar navbar-expand-lg navbar-light nav-main">
                <div class="container">
                    {{-- Logo + Nama Sekolah di Mobile --}}
                    <a class="navbar-brand d-lg-none d-flex align-items-center gap-2 py-1" href="{{ route('landing') }}">
                        <img src="{{ ($profil && $profil->logo) ? asset('storage/'.$profil->logo) : asset('storage/mentahan-logo.jpg') }}" 
                             alt="Logo SMP" 
                             style="width: 38px; height: 38px; object-fit: contain;" 
                             onerror="this.onerror=null;this.src='{{ asset('assets/img/stisla-fill.svg') }}';">
                        <div class="d-flex flex-column justify-content-center">
                            <span class="mobile-logo-title">SMP SAINS AL-QUR'AN</span>
                            <span class="mobile-logo-sub">KLAKAH - LUMAJANG</span>
                        </div>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}"
                                href="{{ route('landing') }}">
                                Beranda
                            </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Profil Kami</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('profil-sekolah') }}">Profil Sekolah</a></li>
                                    <li><a class="dropdown-item" href="{{ route('tenaga-pendidik.index') }}">Tenaga Pendidik</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Program</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('landing') }}#program-unggulan">Program Unggulan</a></li>
                                    <li><a class="dropdown-item" href="{{ route('landing') }}#section-ekskul">Ekstrakurikuler</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('galeri.*') ? 'active' : '' }}" href="{{ route('galeri.index') }}">Galeri</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Informasi</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('informasi.kategori', 'berita') }}">Berita</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                                    <li><a class="dropdown-item" href="{{ route('agenda.index') }}">Agenda</a></li>
                                    <li><a class="dropdown-item" href="{{ route('informasi.kategori', 'prestasi') }}">Prestasi</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('kurikulum.*') ? 'active' : '' }}" href="{{ route('kurikulum.index') }}">Kurikulum</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('raport.*') ? 'active' : '' }}" href="{{ route('raport.panduan') }}">Raport</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}" href="{{ route('pengaduan.front') }}">Pengaduan</a>
                            </li>

                        </ul>

                        {{-- LOGIN BUTTON --}}
                        <div class="d-flex align-items-center ms-lg-3 mt-2 mt-lg-0">
                            @auth
                                @if(auth()->user()->role === 'siswa')
                                    <a href="{{ route('siswa.raport.index') }}" class="nav-login-btn w-100 justify-content-center justify-content-lg-start">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                        <span>Portal Raport</span>
                                    </a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="nav-login-btn w-100 justify-content-center justify-content-lg-start">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Panel Admin</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login.index') }}" class="nav-login-btn w-100 justify-content-center justify-content-lg-start">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    <span>Masuk</span>
                                </a>
                            @endauth
                        </div>

                        {{-- KONTAK DI MENU MOBILE --}}
                        <div class="d-lg-none mt-3 pt-3 border-top">
                            <div class="d-flex flex-column gap-2 small">
                                @if($profil && $profil->telepon)
                                <a href="tel:{{ $profil->telepon }}" class="text-decoration-none text-muted d-flex align-items-center gap-2 py-1">
                                    <div class="contact-icon-mini"><i class="bi bi-telephone-fill"></i></div>
                                    <span>{{ $profil->telepon }}</span>
                                </a>
                                @endif
                                @if($profil && $profil->email)
                                <a href="mailto:{{ $profil->email }}" class="text-decoration-none text-muted d-flex align-items-center gap-2 py-1">
                                    <div class="contact-icon-mini"><i class="bi bi-envelope-fill"></i></div>
                                    <span>{{ $profil->email }}</span>
                                </a>
                                @endif
                                <div class="d-flex align-items-center gap-3 pt-2">
                                    <span class="text-muted small fw-semibold">Ikuti Kami:</span>
                                    @if($profil && $profil->whatsapp)
                                    <a href="https://wa.me/{{ $profil->whatsapp }}" target="_blank" class="text-success fs-5">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                    @endif
                                    @if($profil && $profil->instagram)
                                    <a href="{{ $profil->instagram }}" target="_blank" class="text-danger fs-5">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    @endif
                                    @if($profil && $profil->youtube)
                                    <a href="{{ $profil->youtube }}" target="_blank" class="text-danger fs-5">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>