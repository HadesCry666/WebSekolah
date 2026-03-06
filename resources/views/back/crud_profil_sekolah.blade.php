@extends('layouts.admin.app')

@section('title', 'Edit Profil Sekolah')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Profil Sekolah</h1>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="section-body">
        <h2 class="section-title">Halaman ini digunakan untuk mengubah profil sekolah</h2>

        <div class="card">
            <div class="card-header">
                <h4>Edit Profil Sekolah</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.profil-sekolah.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" class="form-control"
                                   value="{{ old('nama_sekolah', $profil->nama_sekolah) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="tagline" class="form-control"
                                   value="{{ old('tagline', $profil->tagline) }}">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Deskripsi Sekolah</label>
                            <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Visi</label>
                            <textarea name="visi" rows="3" class="form-control">{{ old('visi', $profil->visi) }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Misi</label>
                            <textarea name="misi" rows="3" class="form-control">{{ old('misi', $profil->misi) }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control"
                                   value="{{ old('alamat', $profil->alamat) }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control"
                                   value="{{ old('telepon', $profil->telepon) }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $profil->email) }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gambar / Foto Sekolah</label>
                            @if($profil->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$profil->gambar) }}" alt="" height="80" class="rounded">
                                </div>
                            @endif
                            <input type="file" name="gambar" class="form-control">
                        </div>
                    </div>

                    <button class="btn btn-primary mt-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
