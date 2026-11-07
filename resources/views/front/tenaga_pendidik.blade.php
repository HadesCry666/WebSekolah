@extends('layouts.main')

@section('title', 'Tenaga Pendidik')

@section('content')

<section class="py-5 bg-white">
    <div class="container">
        <div class="mb-4 text-center">
            <h2 class="section-title">Tenaga Pendidik </h2>
            <p class="section-subtitle mb-0">
                Profil guru SMPN Sains Al-Qur'an Klakah
            </p>
        </div>

      {{-- ================== BAGIAN KEPALA SEKOLAH ================== --}}
@if(isset($kepalaSekolah) && $kepalaSekolah->isNotEmpty())
    <div class="mb-3 text-center">
        <h4 class="fw-semibold">Kepala Sekolah</h4>
    </div>

    <div class="row justify-content-center g-4 mb-5">
        @foreach($kepalaSekolah as $g)
            <div class="col-10 col-sm-6 col-md-4 col-lg-3">
                <div class="card card-soft guru-card h-100 text-center border-success border-opacity-25 shadow-sm">
                    <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                    <img src="{{ image_url($g->foto, $g->jenis_kelamin == 'Perempuan' ? asset('assets/img/dummy/guru-wanita.png') : asset('assets/img/dummy/guru-pria.png')) }}"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                         alt="{{ $g->nama }}">
                    <div class="card-body">
                        <span class="badge bg-success bg-opacity-10 text-success mb-2 px-2 py-1" style="font-size: 0.72rem; font-weight: 600;">Kepala Sekolah</span>
                        <div class="fw-semibold">{{ $g->nama }}</div>
                        <div class="small text-muted">{{ $g->pendidikan_terakhir ?? ($g->NIP ? 'NIP. ' . $g->NIP : 'Pimpinan Sekolah') }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

      {{-- ================== BAGIAN GURU ================== --}}
@if($guru->isNotEmpty())
    <div class="mb-3 text-center">
        <h4 class="fw-semibold">Guru</h4>
    </div>

    <div class="row g-4 mb-5">
        @foreach($guru as $g)
            <div class="col-6 col-md-3">
                <div class="card card-soft guru-card h-100 text-center">
                       <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>

                    <img src="{{ image_url($g->foto, $g->jenis_kelamin == 'Perempuan' ? asset('assets/img/dummy/guru-wanita.png') : asset('assets/img/dummy/guru-pria.png')) }}"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                         alt="{{ $g->nama }}">
                    <div class="card-body">
                        <div class="fw-semibold">{{ $g->nama }}</div>
                        <div class="small text-muted">{{ $g->mata_pelajaran ?? '-' }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- ================== BAGIAN TATA USAHA ================== --}}
@if($tataUsaha->isNotEmpty())
    <div class="mb-3 text-center">
        <h4 class="fw-semibold">Tata Usaha</h4>
    </div>

    <div class="row g-4 mb-5">
        @foreach($tataUsaha as $g)
            <div class="col-6 col-md-3">
                <div class="card card-soft guru-card h-100 text-center">
                       <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>

                    <img src="{{ image_url($g->foto, $g->jenis_kelamin == 'Perempuan' ? asset('assets/img/dummy/guru-wanita.png') : asset('assets/img/dummy/guru-pria.png')) }}"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                         alt="{{ $g->nama }}">
                    <div class="card-body">
                        <div class="fw-semibold">{{ $g->nama }}</div>
                        <div class="small text-muted">{{ $g->mata_pelajaran ?? '-' }}</div>
                        <div class="small mt-1">
                            {{ $g->jabatan == 'tata_usaha' ? 'Tata Usaha' : ucfirst($g->jabatan) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- ================== BAGIAN USTADZ ================== --}}
@if($ustadz->isNotEmpty())
    <div class="mb-3 text-center">
        <h4 class="fw-semibold">Ustadz/Ustadzah</h4>
    </div>

    <div class="row g-4 mb-5">
        @foreach($ustadz as $g)
            <div class="col-6 col-md-3">
                <div class="card card-soft guru-card h-100 text-center">
                       <a href="{{ route('tenaga-pendidik.detail', $g->id) }}" class="stretched-link"></a>
                    <img src="{{ image_url($g->foto, $g->jenis_kelamin == 'Perempuan' ? asset('assets/img/dummy/guru-wanita.png') : asset('assets/img/dummy/guru-pria.png')) }}"
                         onerror="this.onerror=null;this.src='{{ asset('assets/img/dummy/guru-pria.png') }}';"
                         alt="{{ $g->nama }}">
                    <div class="card-body">
                        <div class="fw-semibold">{{ $g->nama }}</div>
                        <div class="small text-muted">{{ $g->mata_pelajaran ?? '-' }}</div>
                      <div class="small text-muted mt-1">
                         {{ $g->jenis_kelamin == 'Perempuan' ? 'Ustadzah' : 'Ustadz' }}
                       </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Kalau semua kosong --}}
@if((!isset($kepalaSekolah) || $kepalaSekolah->isEmpty()) && $guru->isEmpty() && $tataUsaha->isEmpty() && $ustadz->isEmpty())
    <div class="col-12 text-center text-muted">
        Belum ada data tenaga pendidik yang ditampilkan.
    </div>
@endif


        {{-- pagination hanya kalau pakai paginate() --}}
        @if($guru instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="mt-4">
                {{ $guru->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
