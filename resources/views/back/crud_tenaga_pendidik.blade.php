@extends('layouts.admin.app')

@section('title', 'Tenaga Pendidik')

@section('content')

<link rel="stylesheet" href="{{ asset('css/alert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
<section class="section">
<div class="section-header">
        <h1>Tenaga Pendidik</h1>
</div>

@if(session('success'))
    <div id="toastNotif" class="toast-notif toast-success">
        <span class="toast-icon">✔</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- ================= FORM TAMBAH TENAGA PENDIDIK ================= --}}
<div class="section-body">
    <h2 class="section-title">Halaman ini menampilkan semua data tenaga pendidik</h2>

    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Tenaga Pendidik</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.tenaga-pendidik.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jabatan</label>
                        <div class="form-group">
                        <select name="jabatan" class="form-control select2" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Guru">Guru</option>
                            <option value="Tata usaha">Tata Usaha</option>
                            <option value="Ustadz">Ustadz</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-control">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">NIP</label>
                        <input type="text" name="NIP" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama" class="form-control">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <div>
                        <select name="jenis_kelamin" class="form-control select2" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Foto (opsional)</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                </div>

                <button class="btn btn-primary mt-3" type="submit">Simpan</button>
            </form>
        </div>
    </div>
</div>

{{-- ================= TABLE TENAGA PENDIDIK ================= --}}
<div class="card mt-4">
    <div class="card-header">
            <h4>Daftar Data Tenaga Pendidik</h4>
        </div>

    <div class="card-body table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="40">#</th>
                    {{-- <th>Foto</th> --}}
                    <th>Nama</th>
                    <th>Mata Pelajaran</th>
                    <th>Jabatan</th>
                    <th>NIP</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        {{-- <td>
                            @if($row->foto)
                                <img src="{{ asset('storage/'.$row->foto) }}" width="60" class="rounded">
                            @else -
                            @endif
                        </td> --}}
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->mata_pelajaran ?? '-' }}</td>
                        <td>{{ $row->jabatan }}</td>
                        <td>{{ $row->NIP }}</td>
                       <td>
                        {{-- Edit --}}
                        <button class="btn btn-primary mr-1"
                                data-toggle="modal"
                                data-target="#editGuru{{ $row->id }}">
                            <i class="far fa-edit"></i>
                        </button>

                        {{-- Hapus --}}
                        <button type="button" class="btn btn-danger btn-delete" data-id="{{ $row->id }}">
                            <i class="fas fa-trash"></i>
                        </button>

                         <form id="delete-form-{{ $row->id }}" 
                            action="{{ route('admin.tenaga-pendidik.destroy', $row->id) }}"
                            method="POST" 
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                        </form>

                    </td>

                    </tr>

                    {{-- =========== Modal Edit =========== --}}
                    <div class="modal fade" id="editGuru{{ $row->id }}" tabindex="-1" role="dialog" data-backdrop="false">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Tenaga Pendidik</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>

                                <form action="{{ route('admin.tenaga-pendidik.update', $row->id) }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            
                                            <div class="col-md-4 mb-4">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama" value="{{ $row->nama }}" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Jabatan</label>
                                                <div class="form-group">
                                                <select name="jabatan" class="form-control select2">
                                                    <option value="Guru" {{ $row->jabatan=='Guru'?'selected':'' }}>Guru</option>
                                                    <option value="Tatau saha" {{ $row->jabatan=='Tata usaha'?'selected':'' }}>Tata Usaha</option>
                                                    <option value="Ustadz" {{ $row->jabatan=='Ustadz'?'selected':'' }}>Ustadz</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Mata Pelajaran</label>
                                                <input type="text" name="mata_pelajaran" value="{{ $row->mata_pelajaran }}" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-4">
                                                <label class="form-label">NIP</label>
                                                <input type="text" name="NIP" value="{{ $row->NIP }}" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Pendidikan Terakhir</label>
                                                <input type="text" name="pendidikan_terakhir" value="{{ $row->pendidikan_terakhir }}" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Agama</label>
                                                <input type="text" name="agama" value="{{ $row->agama }}" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-4">
                                                <label class="form-label">Tempat Lahir</label>
                                                <input type="text" name="tempat_lahir" value="{{ $row->tempat_lahir }}" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" value="{{ $row->tanggal_lahir }}" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Jenis Kelamin</label>
                                                <div class="form-group">
                                                <select name="jenis_kelamin" class="form-control select2">
                                                    <option value="Laki-laki" {{ $row->jenis_kelamin=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                                                    <option value="Perempuan" {{ $row->jenis_kelamin=='Perempuan'?'selected':'' }}>Perempuan</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label class="form-label">Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="2">{{ $row->alamat }}</textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Foto</label><br>
                                                @if($row->foto)
                                                    <img src="{{ asset('storage/'.$row->foto) }}" width="100" class="rounded mb-2">
                                                @endif
                                                <input type="file" name="foto" class="form-control">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</section>
  <script src="{{ asset('assets/modules/select2/dist/js/select2.js') }}"></script>
  <script src="{{ asset('assets/modules/select2/dist/js/select2.min.js') }}"></script>
  <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
  <script src="{{ asset('assets/modules/select2/dist/js/select2.full.js') }}"></script>
  <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/js/sweetalert.js') }}"></script>

@endsection
