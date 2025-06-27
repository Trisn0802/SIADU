@extends('backend.v_layouts.app')

@section('content')
<style>
    .mobile-btn {
        gap: 0.5rem !important;
    }
    .auto-width-btn {
        min-width: 120px;
        margin-bottom: 0.5rem;
    }
</style>
<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.user.update', $edit->id_user) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{$judul}}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>
                                    @if ($edit->foto)
                                        <img src="{{ asset('storage/img-user/' . $edit->foto) }}" class="foto-preview" width="100%">
                                    @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}" class="foto-preview" width="100%">
                                    @endif
                                    <img class="foto-preview-new img-fluid mb-3" style="display: none;" width="100%">
                                    <p></p>
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                    @error('foto')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">

                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" value="{{ old('nik', $edit->nik) }}"
                                        class="form-control @error('nik') is-invalid @enderror" placeholder="NIK Anda" readonly>
                                    @error('nik')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" value="{{ old('nama', $edit->nama) }}"
                                        class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Anda">
                                    @error('nama')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ old('email', $edit->email) }}"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email Anda">
                                    @error('email')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>HP</label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="no_hp"
                                        value="{{ old('no_hp', $edit->no_hp) }}" class="form-control @error('no_hp') is-invalid @enderror"
                                        placeholder="Nomor Anda HP">
                                    @error('no_hp')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    <div class="border-top">
                        <div class="card-body mobile-btn">
                            <button type="submit" class="btn btn-primary auto-width-btn">Perbaharui</button>
                            <a href="{{ route('backend.user.gantipassword', $edit->id_user) }}" class="btn btn-info auto-width-btn">Ganti Password</a>
                            <a href="{{ route('backend.beranda.user') }}" class="btn btn-secondary auto-width-btn">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Content End -->

<!-- Tambahkan script untuk preview gambar -->
<script>
    function previewFoto() {
        const foto = document.querySelector('input[name="foto"]');
        const fotoPreview = document.querySelector('.foto-preview');
        const fotoPreviewNew = document.querySelector('.foto-preview-new');

        const fileReader = new FileReader();
        fileReader.readAsDataURL(foto.files[0]);

        fileReader.onload = function(e) {
            fotoPreview.style.display = 'none';
            fotoPreviewNew.style.display = 'block';
            fotoPreviewNew.src = e.target.result;
        }
    }
</script>
<!-- Content End -->
@endsection
