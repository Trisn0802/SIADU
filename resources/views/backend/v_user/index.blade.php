@extends('backend.v_layouts.app')

@section('content')
    <!-- contentAwal -->
    {{-- <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Selamat Datang, {{ Auth::user()->nama }}</h4> --}}
                        {{-- <hr>
                        <p class="mb-0">Ada masalah pada infrastruktur di dekat lokasi anda segera laporkan!</p> --}}
                    {{-- </div> --}}
    <div class="row">
        <div class="col-12
        {{-- offset-2 --}}
        ">
            <div class="card">
                <div class="card-body border-top">
                    {{-- <h5 class="card-title">{{ $judul }}</h5> --}}
                    <h3 class="card-title text-center">SIADU</h3>
                    <h5 class="text-center">Laporkan kerusakan atau masalah umum di sekitar anda</h5>
                    <form action="{{ route('backend.user.storeaduan') }}" method="post" enctype="multipart/form-data">
                    {{-- <form action="{{ route('backend.user.update', $edit->id_user) }}" method="post" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class="card-body">
                            {{-- <h4 class="card-title">{{$judul}}</h4> --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Foto</label>
                                        <img src="{{ asset('storage/img-pengaduan/img-pengaduan-default.png') }}" class="foto-preview" width="100%" style="border-radius: 5px; border: 1px solid gray;">
                                        <img class="foto-preview-new img-fluid mb-3" style="display: none;" width="100%">
                                        <p></p>
                                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                        @error('foto')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-6 col-sm-12">

                                    <div class="form-group">
                                        <label>Judul Laporan</label>
                                        <input type="text" name="judul"
                                            class="form-control @error('judul') is-invalid @enderror" placeholder="Isi judul laporan">
                                        @error('judul')
                                            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <input type="text" name="lokasi"
                                            class="form-control @error('lokasi') is-invalid @enderror" placeholder="Isi lokasi kejadian">
                                        @error('lokasi')
                                            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi"
                                        class="form-control @error('deskripsi') is-invalid @enderror"
                                        placeholder="Isi deskripsi laporan"></textarea>
                                        @error('deskripsi')
                                            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                            <option value="">- Pilih Kategori -</option>
                                            <option value="Infrastruktur">infrastruktur</option>
                                            <option value="Pelayanan">Pelayanan</option>
                                            <option value="Lain-lain">Lain-Lain</option>
                                        </select>
                                        @error('kategori')
                                            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                    </form>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-info">
                            {{-- <i class="bi bi-plus-circle-fill"></i> --}}
                            Buat Aduan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-6">
            <div class="card">
                <div class="card-body border-top">
                    <h5 class="card-title">{{ $judul }}</h5>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Selamat Datang, {{ Auth::user()->nama }}</h4>
                        Aplikasi SIADU dengan hak akses yang anda miliki sebagai
                        <b>
                            @if (Auth::user()->role == 1)
                                Admin
                            @elseif(Auth::user()->role == 0)
                                User
                            @endif
                        </b>
                        <br>
                        Bikin aplikasi ini pake Laravel 10, Bootstrap 5, dan MySQL.
                        <hr>
                        <p class="mb-0">Kuliah..? BSI Aja !!!</p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- contentAkhir -->
@endsection
