 {{-- ================= HEADER (TOP + NAVBAR) ================= --}}
        <header>
            {{-- TOP HEADER --}}
            <div class="header-top">
                <div class="container d-flex flex-wrap justify-content-between align-items-center">
                    {{-- Logo kiri --}}
                    <div class="logo-wrap d-flex align-items-center gap-2">
                        {{-- ganti asset logo dengan punyamu --}}
                        <img src="{{ asset('storage/mentahan-logo.jpg') }}" alt="Logo SMP">
                        <div class="d-none d-md-block">
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
                                <div class="contact-value">(0334) 881866</div>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon-circle">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <div class="contact-label">Alamat Email</div>
                                <div class="contact-value">info@smpcontoh.sch.id</div>
                            </div>
                        </div>

                    <div class="d-flex align-items-center">
                        <div class="social-divider d-none d-lg-block"></div>
                        <div class="social-list">
                            <a href="https://wa.me/6287612346453" 
                            class="text-success" 
                            target="_blank">
                                <i class="bi bi-whatsapp"></i>
                            </a>

                            <a href="https://www.instagram.com/smpsainsquranklakah/" 
                            class="text-danger" 
                            target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>

                            <a href="https://www.youtube.com/@smpsainsquranklakah" 
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
                    <a class="navbar-brand d-lg-none" href="#">SMP SAINS AL-QUR'AN</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                              <a class="nav-link"
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
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Kurikulum</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Kurikulum Sekolah</a></li>
                                    <li><a class="dropdown-item" href="#">Mata Pelajaran</a></li>
                                   <li>
                                        <a class="dropdown-item"
                                        href="{{ route('landing') }}#section-ekskul">
                                            Ekstrakurikuler
                                        </a>
                                   </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Program Keahlian</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Program 1</a></li>
                                    <li><a class="dropdown-item" href="#">Program 2</a></li>
                                    <li><a class="dropdown-item" href="#">Program 3</a></li>
                                </ul>
                            </li>

                            {{-- <li class="nav-item"><a class="nav-link" href="#">Agenda</a></li> --}}
                            <li class="nav-item"><a class="nav-link" href="#">Galeri</a></li>

                          <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Informasi</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('informasi.kategori', 'berita') }}">
                                            Berita
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('informasi.kategori', 'prestasi') }}">
                                            Prestasi
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pengaduan.front') }}">Pengaduan</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </header>