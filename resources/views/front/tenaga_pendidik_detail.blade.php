@extends('layouts.main')

@section('title', 'Detail Tenaga Pendidik')

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm mb-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="card shadow-sm rounded-4 p-4 border-0">
            <div class="row g-4 align-items-center">

                {{-- FOTO 3x4 --}}
                <div class="col-md-4 text-center">
                    <div class="guru-photo-wrapper mx-auto">
                        <img
                            src="{{ $guru->foto 
                                ? asset('storage/'.$guru->foto) 
                                : 'https://via.placeholder.com/400x600?text=Foto+Guru' }}"
                            alt="{{ $guru->nama }}"
                            class="guru-photo">
                    </div>
                </div>

                {{-- DATA --}}
                <div class="col-md-8">
                    <h3 class="fw-bold mb-1">{{ $guru->nama }}</h3>

                    @if($guru->jabatan || $guru->mata_pelajaran)
                        <p class="text-muted mb-3">
                            {{ $guru->jabatan ?? '' }}
                            @if($guru->jabatan && $guru->mata_pelajaran)
                                •
                            @endif
                            {{ $guru->mata_pelajaran ?? '' }}
                        </p>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-borderless table-sm align-middle">
                            <tbody>
                                <tr>
                                    <th width="220">NIP</th>
                                    <td>{{ $guru->NIP ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pendidikan Terakhir</th>
                                    <td>{{ $guru->pendidikan_terakhir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>{{ $guru->agama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td>
                                        {{ $guru->tempat_lahir ?? '-' }},
                                        {{ $guru->tanggal_lahir
                                            ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d M Y')
                                            : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $guru->jenis_kelamin ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $guru->alamat ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection
