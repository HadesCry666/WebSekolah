<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Raport Siswa — SMP Sains Al-Qur'an Klakah</title>

    {{-- Favicon --}}
    @php
        $profilSiswa = \App\Models\ProfilSekolah::first();
        $siswaFavicon = ($profilSiswa && $profilSiswa->favicon) 
            ? asset('storage/'.$profilSiswa->favicon) 
            : (($profilSiswa && $profilSiswa->logo) 
                ? asset('storage/'.$profilSiswa->logo) 
                : asset('favicon.png'));
    @endphp
    <link rel="icon" type="image/png" href="{{ $siswaFavicon }}">
    <link rel="shortcut icon" href="{{ $siswaFavicon }}">
    <link rel="apple-touch-icon" href="{{ $siswaFavicon }}">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --primary-light: #e0f2fe;
            --surface: #ffffff;
            --background: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
        .portal-navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            padding: 14px 24px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .portal-container {
            max-width: 1080px;
            margin: 0 auto;
            width: 100%;
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-main);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);
        }

        .brand-title {
            font-weight: 800;
            font-size: 1rem;
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .brand-sub {
            font-size: 0.72rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }

        .user-nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 999px;
            border: 1px solid #fee2e2;
            background: #fef2f2;
            color: #dc2626;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* ── HERO / PROFILE CARD ── */
        .portal-body {
            padding: 32px 20px 60px;
            flex: 1;
        }

        .profile-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 20px;
            padding: 32px;
            color: #ffffff;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15);
        }

        .profile-banner::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(2, 132, 199, 0.15);
            pointer-events: none;
        }

        .profile-content {
            display: flex;
            align-items: center;
            gap: 24px;
            position: relative;
            z-index: 1;
            flex-wrap: wrap;
        }

        .avatar-wrap {
            width: 84px;
            height: 84px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .profile-badges {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .p-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .p-badge.highlight {
            background: #0284c7;
            border-color: #38bdf8;
            color: #fff;
            font-weight: 700;
        }

        /* ── SECTION HEADER ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        /* ── RAPORT CARDS GRID ── */
        .raport-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .raport-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 24px;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .raport-card:hover {
            transform: translateY(-3px);
            border-color: #93c5fd;
            box-shadow: 0 12px 24px -4px rgba(2, 132, 199, 0.12);
        }

        .rc-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .rc-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .rc-badge {
            padding: 5px 12px;
            background: #dcfce7;
            color: #15803d;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .rc-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .rc-sub {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 14px;
        }

        .rc-notes {
            background: #f8fafc;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.8rem;
            color: #475569;
            margin-bottom: 20px;
            line-height: 1.5;
            border-left: 3px solid var(--primary);
        }

        .rc-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-download {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: #ffffff;
            padding: 11px 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
        }

        .btn-download:hover {
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
            transform: translateY(-1px);
            color: #ffffff;
        }

        .btn-preview {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #475569;
            border-radius: 12px;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.2s;
        }

        .btn-preview:hover {
            background: #e2e8f0;
            color: var(--text-main);
        }

        /* Empty state */
        .empty-raport {
            background: #ffffff;
            border: 2px dashed #cbd5e1;
            border-radius: 20px;
            padding: 48px 24px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-icon {
            font-size: 3rem;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        /* Footer */
        .portal-footer {
            text-align: center;
            padding: 24px;
            color: var(--text-muted);
            font-size: 0.8rem;
            border-top: 1px solid var(--border);
            background: #ffffff;
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="portal-navbar">
        <div class="portal-container">
            <div class="nav-content">
                <a href="{{ url('/') }}" class="brand">
                    <div class="brand-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <div class="brand-title">SMP Sains Al-Qur'an</div>
                        <div class="brand-sub">Portal Raport Siswa</div>
                    </div>
                </a>

                <div class="user-nav-actions">
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- BODY --}}
    <main class="portal-body">
        <div class="portal-container">

            {{-- ALERTS --}}
            @if(session('success'))
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; color: #166534; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-check-circle-fill" style="font-size: 1.1rem;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error') || isset($error))
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; color: #dc2626; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.1rem;"></i>
                    <span>{{ session('error') ?? $error }}</span>
                </div>
            @endif

            {{-- PROFILE BANNER --}}
            @if($siswa)
            <div class="profile-banner">
                <div class="profile-content">
                    <div class="avatar-wrap">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama }}">
                        @else
                            {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                        @endif
                    </div>
                    <div class="profile-info">
                        <h1>{{ $siswa->nama }}</h1>
                        <div class="profile-badges">
                            @if($siswa->nisn)
                            <span class="p-badge highlight">
                                <i class="bi bi-card-heading"></i> NISN: {{ $siswa->nisn }}
                            </span>
                            @endif
                            @if($siswa->nik)
                            <span class="p-badge">
                                <i class="bi bi-credit-card-2-front"></i> NIK: {{ $siswa->nik }}
                            </span>
                            @endif
                            <span class="p-badge">
                                <i class="bi bi-person-badge"></i> NIS: {{ $siswa->nis }}
                            </span>
                            <span class="p-badge">
                                <i class="bi bi-building"></i> Kelas {{ $siswa->kelas ?? '-' }}
                            </span>
                            <span class="p-badge">
                                <i class="bi bi-person"></i> {{ $siswa->jenis_kelamin_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- SECTION: DAFTAR RAPORT --}}
            <div class="section-header">
                <div class="section-title">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Berkas Raport Akademik</span>
                </div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    Total: <strong>{{ $raports->count() }}</strong> Berkas Tersedia
                </div>
            </div>

            @if($raports->count() > 0)
                <div class="raport-grid">
                    @foreach($raports as $r)
                        <div class="raport-card">
                            <div>
                                <div class="rc-top">
                                    <div class="rc-icon">
                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                    </div>
                                    <span class="rc-badge">Siap Download</span>
                                </div>
                                <h3 class="rc-title">Tahun Ajaran {{ $r->tahun_ajaran }}</h3>
                                <div class="rc-sub">
                                    Semester <strong>{{ ucfirst($r->semester) }}</strong> • Rilis {{ $r->updated_at->format('d M Y') }}
                                </div>

                                @if($r->catatan)
                                    <div class="rc-notes">
                                        <i class="bi bi-chat-quote-fill" style="margin-right: 4px; color: var(--primary);"></i>
                                        {{ $r->catatan }}
                                    </div>
                                @endif
                            </div>

                            <div class="rc-actions">
                                <a href="{{ route('siswa.raport.download', $r->id) }}" class="btn-download">
                                    <i class="bi bi-cloud-arrow-down-fill"></i> Download PDF
                                </a>
                                <a href="{{ route('siswa.raport.preview', $r->id) }}" target="_blank" class="btn-preview" title="Buka PDF di Tab Baru">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-raport">
                    <div class="empty-icon">
                        <i class="bi bi-folder-x"></i>
                    </div>
                    <h3 style="font-size: 1.15rem; color: var(--text-main); font-weight: 700; margin-bottom: 6px;">
                        Belum Ada Raport yang Dipublikasikan
                    </h3>
                    <p style="font-size: 0.88rem; max-width: 440px; margin: 0 auto; line-height: 1.6;">
                        Berkas raport Anda untuk semester ini belum diunggah atau belum dibuka oleh pihak sekolah. Silakan cek secara berkala atau hubungi wali kelas.
                    </p>
                </div>
            @endif

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="portal-footer">
        © {{ date('Y') }} SMP Sains Al-Qur'an Klakah. Seluruh Hak Cipta Dilindungi.
    </footer>

</body>
</html>
