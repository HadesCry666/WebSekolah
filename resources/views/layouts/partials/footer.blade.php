{{-- ================= FOOTER ================= --}}
@php
    $profilFooter = \App\Models\ProfilSekolah::first();
    $logoFooter = image_url($profilFooter?->logo, asset('assets/img/logo.png'));
@endphp

<footer class="footer-main mt-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            {{-- KOLOM 1: IDENTITAS, KONTAK, DAN SOSIAL MEDIA --}}
            <div class="col-lg-4 col-md-5">
                <div class="footer-brand d-flex align-items-center gap-3 mb-3">
                    <div class="footer-logo-badge">
                        <img src="{{ $logoFooter }}" alt="Logo SMP Sains Al-Qur'an Klakah" onerror="this.onerror=null;this.src='{{ asset('assets/img/logo.png') }}';">
                    </div>
                    <div>
                        <h5 class="footer-brand-title mb-0">SMP SAINS AL-QUR'AN</h5>
                        <div class="footer-brand-sub">KLAKAH • LUMAJANG</div>
                        <p class="footer-tagline mb-0">{{ $profilFooter->tagline ?? 'Membentuk Generasi Qur\'ani yang Cerdas, Mandiri, dan Berakhlak Mulia' }}</p>
                    </div>
                </div>

                <div class="footer-contact-list">
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <span>{{ $profilFooter->alamat ?? 'Kecamatan Klakah, Kabupaten Lumajang, Jawa Timur' }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $profilFooter->telepon ?? '+6282233671882') }}">{{ $profilFooter->telepon ?? '+62 822-3367-1882' }}</a>
                    </div>
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <a href="mailto:{{ $profilFooter->email ?? 'saqusmp@gmail.com' }}">{{ $profilFooter->email ?? 'saqusmp@gmail.com' }}</a>
                    </div>
                </div>

                <div class="footer-social-wrap">
                    <div class="footer-social-label">Media Sosial</div>
                    <div class="footer-social-links">
                        <a href="https://wa.me/{{ $profilFooter->whatsapp ?? '6282233671882' }}" class="footer-social-btn whatsapp" target="_blank" title="WhatsApp" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="{{ $profilFooter->instagram ?? 'https://www.instagram.com/smpsainsquranklakah?utm_source=ig_web_button_share_sheet&psln=ZDNlZDc0MzIxNw==' }}" class="footer-social-btn instagram" target="_blank" title="Instagram" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="{{ $profilFooter->facebook ?? 'https://www.facebook.com/share/19yzmuuc6A/' }}" class="footer-social-btn facebook" target="_blank" title="Facebook" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="{{ $profilFooter->youtube ?? 'https://www.youtube.com/@smpsainsquranklakah' }}" class="footer-social-btn youtube" target="_blank" title="YouTube" aria-label="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- DIVIDER ON MOBILE --}}
            <div class="col-12 d-md-none p-0">
                <hr class="footer-divider-mobile">
            </div>

            {{-- KOLOM 2: MENU UTAMA (col-6 di mobile agar rapi bersebelahan) --}}
            <div class="col-6 col-md-2 col-lg-2">
                <h6 class="footer-heading">Menu Utama</h6>
                <ul class="footer-nav-list list-unstyled">
                    <li><a href="{{ route('profil-sekolah') }}"><i class="bi bi-chevron-right"></i> Profil</a></li>
                    <li><a href="{{ route('tenaga-pendidik.index') }}"><i class="bi bi-chevron-right"></i> Guru & Staf</a></li>
                    <li><a href="{{ route('galeri.index') }}"><i class="bi bi-chevron-right"></i> Galeri</a></li>
                    <li><a href="{{ route('agenda.index') }}"><i class="bi bi-chevron-right"></i> Agenda</a></li>
                    <li><a href="{{ route('kurikulum.index') }}"><i class="bi bi-chevron-right"></i> Kurikulum</a></li>
                    <li><a href="{{ route('pengaduan.front') }}"><i class="bi bi-chevron-right"></i> Pengaduan</a></li>
                </ul>
            </div>

            {{-- KOLOM 3: INFORMASI (col-6 di mobile agar rapi bersebelahan) --}}
            <div class="col-6 col-md-2 col-lg-2">
                <h6 class="footer-heading">Informasi</h6>
                <ul class="footer-nav-list list-unstyled">
                    <li><a href="{{ route('informasi.kategori', 'berita') }}"><i class="bi bi-chevron-right"></i> Berita</a></li>
                    <li><a href="{{ route('pengumuman.index') }}"><i class="bi bi-chevron-right"></i> Pengumuman</a></li>
                    <li><a href="{{ route('informasi.kategori', 'prestasi') }}"><i class="bi bi-chevron-right"></i> Prestasi</a></li>
                    <li><a href="{{ url('/rapot') }}"><i class="bi bi-chevron-right"></i> Raport Siswa</a></li>
                </ul>
            </div>

            {{-- KOLOM 4: LOKASI KAMI --}}
            <div class="col-12 col-md-3 col-lg-4 mt-3 mt-md-0">
                <h6 class="footer-heading">Lokasi Kami</h6>
                <div class="footer-map-wrap">
                    <iframe 
                        src="{{ $profilFooter->maps_embed ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126425.49257840867!2d113.16242646611147!3d-8.019894112444272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd65bfaa61c7e27%3A0xa113f43ba4a9a688!2sYAHTADI%20ISLAMIC%20EDUCATION%20CENTER!5e0!3m2!1sid!2sid!4v1764706817064!5m2!1sid!2sid' }}" 
                        style="border:0;" 
                        allowfullscreen 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="mt-2 text-start">
                    <a href="https://maps.google.com/?q=YAHTADI+ISLAMIC+EDUCATION+CENTER+Klakah" target="_blank" class="footer-map-link">
                        <i class="bi bi-box-arrow-up-right"></i> Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- COPYRIGHT BAR --}}
<div class="footer-bottom">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-1 text-center text-md-start">
            <div>
                © {{ date('Y') }} <strong>SMP Sains Al-Qur'an Klakah</strong>. All rights reserved.
            </div>
            <div style="color: #6ee7b7; font-size: 0.78rem;">
                Islamic Character & Modern Science
            </div>
        </div>
    </div>
</div>
