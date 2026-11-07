<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SMP Sains Al-Qur'an Klakah</title>

    {{-- Favicon --}}
    @php
        $profilLogin = \App\Models\ProfilSekolah::first();
        $loginFavicon = ($profilLogin && $profilLogin->favicon) 
            ? image_url($profilLogin->favicon) 
            : (($profilLogin && $profilLogin->logo) 
                ? image_url($profilLogin->logo) 
                : asset('favicon.png'));
    @endphp
    <link rel="icon" type="image/png" href="{{ $loginFavicon }}">
    <link rel="shortcut icon" href="{{ $loginFavicon }}">
    <link rel="apple-touch-icon" href="{{ $loginFavicon }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0d5c3a;
            --primary-dark: #083d26;
            --primary-light: #16a34a;
            --accent: #e8f5e9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #083d26 0%, #0d5c3a 40%, #16a34a 100%);
            position: relative;
            overflow: hidden;
        }

        /* Decorative blobs */
        body::before {
            content: '';
            position: fixed;
            top: -120px;
            left: -120px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -100px;
            right: -100px;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .login-wrapper {
            width: 100%;
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Left panel */
        .login-brand-panel {
            flex: 1;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            position: relative;
            color: white;
        }

        @media (min-width: 992px) {
            .login-brand-panel {
                display: flex;
            }
        }

        .brand-logo-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
        }

        .brand-logo-circle i {
            font-size: 2.4rem;
            color: #fff;
        }

        .brand-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            text-align: center;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 1rem;
            color: rgba(255,255,255,0.75);
            text-align: center;
            max-width: 320px;
            line-height: 1.7;
        }

        .brand-features {
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
            max-width: 340px;
        }

        .brand-feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 14px 18px;
            border: 1px solid rgba(255,255,255,0.12);
        }

        .brand-feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-feature-icon i {
            font-size: 1.1rem;
            color: #fff;
        }

        .brand-feature-text {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
        }

        /* Right panel / card */
        .login-form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 100%;
            padding: 24px;
        }

        @media (min-width: 992px) {
            .login-form-panel {
                flex: 0 0 440px;
                padding: 48px 40px;
                background: #f5f7fb;
                border-radius: 0;
                min-height: 100vh;
            }
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        @media (min-width: 992px) {
            .login-card {
                box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header .school-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #0d5c3a, #16a34a);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .login-header .school-icon i {
            font-size: 1.8rem;
            color: #fff;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.05rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 44px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #111827;
            background: #f9fafb;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .form-control-custom:focus {
            border-color: #0d5c3a;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 92, 58, 0.1);
        }

        .form-control-custom:focus ~ .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: #0d5c3a;
        }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            font-size: 1.05rem;
            transition: color 0.2s;
        }

        .toggle-pw:hover {
            color: #0d5c3a;
        }

        .error-msg {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .alert-login-error {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.875rem;
            color: #dc2626;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #0d5c3a 0%, #16a34a 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            letter-spacing: 0.01em;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15, 76, 117, 0.35);
            opacity: 0.95;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login .btn-spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .login-footer {
            display: none;
        }

        /* ── BACK TO HOME (floating, always visible) ── */
        .btn-back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(8px);
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .btn-back-home i {
            font-size: 0.75rem;
            transition: transform 0.2s ease;
        }

        .btn-back-home:hover {
            background: rgba(255,255,255,0.22);
            color: #ffffff;
            border-color: rgba(255,255,255,0.4);
        }

        .btn-back-home:hover i {
            transform: translateX(-3px);
        }

        @media (min-width: 992px) {
            .btn-back-home {
                top: 24px;
                left: 24px;
            }
        }

        .back-to-site {
            display: none;
        }

        .back-to-site-desktop {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">

        {{-- Floating Back Button (always visible) --}}
        <a href="{{ url('/') }}" class="btn-back-home">
            <i class="bi bi-arrow-left"></i>
            Beranda
        </a>
        <div class="login-brand-panel">
            <div class="brand-logo-circle">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="brand-title">SMP Sains<br>Al-Qur'an Klakah</div>
            <p class="brand-subtitle">
                Sistem Informasi Manajemen Sekolah — kelola konten website dengan mudah dan efisien.
            </p>

            <div class="brand-features">
                <div class="brand-feature-item">
                    <div class="brand-feature-icon"><i class="bi bi-shield-check"></i></div>
                    <span class="brand-feature-text">Akses aman & terproteksi</span>
                </div>
                <div class="brand-feature-item">
                    <div class="brand-feature-icon"><i class="bi bi-speedometer2"></i></div>
                    <span class="brand-feature-text">Dashboard informatif & real-time</span>
                </div>
                <div class="brand-feature-item">
                    <div class="brand-feature-icon"><i class="bi bi-pencil-square"></i></div>
                    <span class="brand-feature-text">Kelola konten tanpa coding</span>
                </div>
            </div>

            <a href="{{ url('/') }}" class="back-to-site-desktop">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Website
            </a>
        </div>

        {{-- Right Form Panel --}}
        <div class="login-form-panel">
            <div class="login-card">
                <div class="login-header">
                    <div class="school-icon">
                        <i class="bi bi-person-lock"></i>
                    </div>
                    <h1>Portal Masuk</h1>
                    <p>Masuk sebagai Admin atau Siswa</p>
                </div>

                {{-- Error alert --}}
                @if(session('error'))
                    <div class="alert-login-error">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">Email Admin atau NISN Siswa</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person-badge input-icon"></i>
                            <input
                                type="text"
                                name="email"
                                id="email"
                                class="form-control-custom"
                                value="{{ old('email') }}"
                                placeholder="Email admin atau NISN siswa"
                                autocomplete="username"
                                required>
                        </div>
                        @error('email')
                            <div class="error-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password Admin atau NIK Siswa</label>
                        <div class="input-wrapper">
                            <i class="bi bi-shield-lock input-icon"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control-custom"
                                placeholder="Password admin atau 16 digit NIK siswa"
                                autocomplete="current-password"
                                required>
                            <i class="bi bi-eye-slash toggle-pw" id="togglePw"></i>
                        </div>
                        @error('password')
                            <div class="error-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="btn-spinner" id="loginSpinner"></span>
                        <span id="loginBtnText">Masuk Sekarang</span>
                    </button>
                </form>

                <div class="login-footer"></div>
            </div>
        </div>

    </div>

    <script>
        // Toggle password visibility
        const togglePw = document.getElementById('togglePw');
        const pwInput = document.getElementById('password');
        if (togglePw && pwInput) {
            togglePw.addEventListener('click', function() {
                const isHidden = pwInput.type === 'password';
                pwInput.type = isHidden ? 'text' : 'password';
                this.classList.toggle('bi-eye', isHidden);
                this.classList.toggle('bi-eye-slash', !isHidden);
            });
        }

        // Loading state on submit
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('loginBtn');
        const spinner = document.getElementById('loginSpinner');
        const btnText = document.getElementById('loginBtnText');
        if (form) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                spinner.style.display = 'inline-block';
                btnText.textContent = 'Memproses...';
            });
        }
    </script>
</body>
</html>
