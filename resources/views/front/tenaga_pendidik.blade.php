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

                    <img src="{{ $g->foto ? asset('storage/'.$g->foto) : 'https://via.placeholder.com/400x260?text=Guru' }}" alt="{{ $g->nama }}">
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

                    <img src="{{ $g->foto ? asset('storage/'.$g->foto) : 'https://via.placeholder.com/400x260?text=Guru' }}" alt="{{ $g->nama }}">
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
                    <img src="{{ $g->foto ? asset('storage/'.$g->foto) : 'https://via.placeholder.com/400x260?text=Guru' }}" alt="{{ $g->nama }}">
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
@if($guru->isEmpty() && $tataUsaha->isEmpty() && $ustadz->isEmpty())
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
