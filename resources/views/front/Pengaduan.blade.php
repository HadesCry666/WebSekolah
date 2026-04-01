@extends('layouts.main')

@section('title', 'Pengaduan')

@section('content')
<div class="container py-5">

    <h2 class="mb-4">Form Pengaduan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pengaduan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ old('nama') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email (opsional)</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">No. HP (opsional)</label>
                    <input type="text" name="no_hp" class="form-control"
                           value="{{ old('no_hp') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Pengaduan</label>
                    <input type="text" name="judul" class="form-control"
                           value="{{ old('judul') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Isi Pengaduan</label>
                    <textarea name="isi" rows="5" class="form-control" required>{{ old('isi') }}</textarea>
                </div>

                <button class="btn btn-primary">
                    Kirim Pengaduan
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
