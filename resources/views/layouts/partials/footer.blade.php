    {{-- ================= FOOTER ================= --}}
@php
    $profilFooter = \App\Models\ProfilSekolah::first();
@endphp
            <footer class="footer-main mt-4">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ ($profilFooter && $profilFooter->logo) ? asset('storage/'.$profilFooter->logo) : asset('storage/mentahan-logo.jpg') }}" alt="Logo" class="me-2" style="width:80px;height:80px;object-fit:cover;" onerror="this.onerror=null;this.src='{{ asset('assets/img/stisla-fill.svg') }}';">
                                <div>
                                    <h5 class="mb-0">SMP SAINS AL-QUR'AN KLAKAH</h5>
                                    <small>{{ $profilFooter->tagline ?? 'Berkualitas & Berakhlak Mulia' }}</small>
                                </div>
                            </div>
                            <p class="small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $profilFooter->alamat ?? 'Kecamatan Klakah, Kabupaten Lumajang, Jawa Timur' }}</p>
                            <p class="small mb-2"><i class="bi bi-telephone me-1"></i>{{ $profilFooter->telepon ?? '(0334) 881866' }}</p>
                            <p class="small mb-3"><i class="bi bi-envelope me-1"></i>{{ $profilFooter->email ?? 'info@smpsainsquran.sch.id' }}</p>
                            <h6 class="mb-2">Sosial Media</h6>
                            <div class="d-flex">
                                <a href="https://wa.me/{{ $profilFooter->whatsapp ?? '6287612346453' }}" class="social-icon" target="_blank">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="{{ $profilFooter->instagram ?? 'https://www.instagram.com/smpsainsquranklakah/' }}" class="social-icon" target="_blank">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="{{ $profilFooter->youtube ?? 'https://www.youtube.com/@smpsainsquranklakah' }}" class="social-icon" target="_blank">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h6 class="mb-3">Menu Utama</h6>
                            <ul class="list-unstyled small">
                                <li><a href="{{ route('profil-sekolah') }}">Profil Sekolah</a></li>
                                <li><a href="{{ route('tenaga-pendidik.index') }}">Tenaga Pendidik</a></li>
                                <li><a href="{{ route('galeri.index') }}">Galeri</a></li>
                                <li><a href="{{ route('agenda.index') }}">Agenda</a></li>
                                <li><a href="{{ route('kurikulum.index') }}">Kurikulum</a></li>
                                <li><a href="{{ route('pengaduan.front') }}">Pengaduan</a></li>
                            </ul>
                        </div>

                        <div class="col-md-2">
                            <h6 class="mb-3">Informasi</h6>
                            <ul class="list-unstyled small">
                                <li><a href="{{ route('informasi.kategori', 'berita') }}">Berita</a></li>
                                <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                                <li><a href="{{ route('informasi.kategori', 'prestasi') }}">Prestasi</a></li>
                            </ul>
                        </div>

                    <div class="col-md-3">
                            <h6 class="mb-3">Lokasi Kami</h6>
                            <div class="ratio ratio-4x3">
                                <iframe 
                                    src="{{ $profilFooter->maps_embed ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126425.49257840867!2d113.16242646611147!3d-8.019894112444272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd65bfaa61c7e27%3A0xa113f43ba4a9a688!2sYAHTADI%20ISLAMIC%20EDUCATION%20CENTER!5e0!3m2!1sid!2sid!4v1764706817064!5m2!1sid!2sid' }}" 
                                    style="border:0;" 
                                    allowfullscreen 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

             <div class="text-center py-2" style="background-color: #0a3b5b; color: #fff;">
     SMP SAINS AL-QUR'AN KLAKAH © {{ date('Y') }}
</div>
