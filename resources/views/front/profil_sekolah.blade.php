@extends('layouts.main')

@section('title', 'Profil Sekolah')

@section('content')
<div class="container py-5">

    <h1 class="mb-3">{{ $profil->nama_sekolah ?? 'Profil Sekolah' }}</h1>
    <p class="text-muted mb-4">{{ $profil->tagline ?? 'Berkualitas & Berakhlak Mulia' }}</p>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="ratio ratio-4x3">
                    <img
                        src="{{ $profil && $profil->gambar
                                ? asset('storage/'.$profil->gambar)
                                : 'https://via.placeholder.com/800x600?text=Profil+Sekolah' }}"
                        alt="Profil Sekolah"
                        class="w-100 h-100 object-fit-cover"
                    >
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="mb-4">
                <h3 class="h5 fw-bold mb-2">Deskripsi Sekolah</h3>
                <p class="mb-0 text-muted">
                    {!! nl2br(e($profil->deskripsi ?? 'Belum ada deskripsi sekolah.')) !!}
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <h3 class="h6 fw-bold">Visi</h3>
                    <p class="mb-0 text-muted">
                        {!! nl2br(e($profil->visi ?? 'Belum ada visi.')) !!}
                    </p>
                </div>
                <div class="col-md-6">
                    <h3 class="h6 fw-bold">Misi</h3>
                    <p class="mb-0 text-muted">
                        {!! nl2br(e($profil->misi ?? 'Belum ada misi.')) !!}
                    </p>
                </div>
            </div>

            <hr class="my-4">

            <div class="row small text-muted">
                <div class="col-md-6">
                    <div class="fw-semibold">Alamat</div>
                    <div>{{ $profil->alamat ?? '-' }}</div>
                </div>
                <div class="col-md-3 mt-3 mt-md-0">
                    <div class="fw-semibold">Telepon</div>
                    <div>{{ $profil->telepon ?? '-' }}</div>
                </div>
                <div class="col-md-3 mt-3 mt-md-0">
                    <div class="fw-semibold">Email</div>
                    <div>{{ $profil->email ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
