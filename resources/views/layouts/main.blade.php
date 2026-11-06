<!DOCTYPE html>
<html lang="id">
<head>
    @php
        $profilMeta = \App\Models\ProfilSekolah::first();
    @endphp
    <meta charset="UTF-8">
    <title>@yield('title', 'Beranda') - SMP Sains Al-Qur'an Klakah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $profilMeta->meta_description ?? 'Website resmi SMP Sains Al-Qur\'an Klakah - Membentuk Generasi Qur\'ani yang Cerdas, Mandiri, dan Berakhlak Mulia' }}">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="@yield('title', 'Beranda') - SMP Sains Al-Qur'an Klakah">
    <meta property="og:description" content="{{ $profilMeta->meta_description ?? 'Website resmi SMP Sains Al-Qur\'an Klakah' }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $faviconUrl = ($profilMeta && $profilMeta->favicon) 
            ? asset('storage/'.$profilMeta->favicon) 
            : (($profilMeta && $profilMeta->logo) 
                ? asset('storage/'.$profilMeta->logo) 
                : asset('favicon.png'));
    @endphp
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

</head>
<body>

    {{-- INCLUDE HEADER --}}
    @include('layouts.partials.header')

    {{-- KONTEN HALAMAN --}}
    <main>
        @yield('content')
    </main>

    {{-- INCLUDE FOOTER --}}
    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
