@extends('Backend.V_Layouts.App')
@section('content')
<style>
                            .form-group .password-input-wrapper {
                                display: flex;
                                /* justify-content: baseline; */
                                /* text-align: start; */
                                align-items: center;
                                gap: 10px;
                            }
                            .form-group .password-icon {
                                vertical-align: middle
                                transform: translateY(-50%);
                                cursor: pointer;
                                z-index: 2;
                            }
</style>

<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{$judul}}</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <img src="{{ asset('storage/img-pengaduan/img-pengaduan-default.png') }}" class="foto-preview mb-3" width="100%" style="border-radius: 5px; border: 1px solid gray;">
                                    <img class="foto-preview img-fluid mb-3" style="max-height: 300px; display: none;">
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                    @error('foto')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Hak Akses</label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                                        <option value="" {{ old('role') == '' ? 'selected' : '' }}>- Pilih Hak Akses -</option>
                                        <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Petugas</option>
                                        {{-- <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>User</option> --}}
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror" placeholder="Masukkan NIK">
                                    @error('nik')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama">
                                    @error('nama')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email">
                                    @error('email')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>HP</label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="no_hp" value="{{ old('no_hp') }}" class="form-control @error('no_hp') is-invalid @enderror" placeholder="Masukkan Nomor HP">
                                    @error('no_hp')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Instansi</label>
                                    <input type="text" name="instansi" value="{{ old('instansi') }}" class="form-control @error('instansi') is-invalid @enderror" placeholder="Masukkan instansi">
                                    @error('instansi')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <span class="fa fa-eye password-icon-2" aria-hidden="true" onclick="showPasswordBaru()"></span>
                                    <input type="password" id="passwordInputBaru" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password">
                                    @error('password')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <span class="fa fa-eye password-icon-3" aria-hidden="true" onclick="showPasswordKonfirmasi()"></span>
                                    <input type="password" id="passwordInputKonfirmasi" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('backend.user.showUser') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Skrip untuk hide dan un hide input password --}}
<script>
                            function showPasswordBaru() {
                                var x = document.getElementById("passwordInputBaru");
                                var icon = document.querySelector(".password-icon-2");
                                if (x.type === "password") {
                                    x.type = "text";
                                    icon.classList.remove("fa-eye");
                                    icon.classList.add("fa-eye-slash");
                                } else {
                                    x.type = "password";
                                    icon.classList.remove("fa-eye-slash");
                                    icon.classList.add("fa-eye");
                                }
                            }

                            function showPasswordKonfirmasi() {
                                var x = document.getElementById("passwordInputKonfirmasi");
                                var icon = document.querySelector(".password-icon-3");
                                if (x.type === "password") {
                                    x.type = "text";
                                    icon.classList.remove("fa-eye");
                                    icon.classList.add("fa-eye-slash");
                                } else {
                                    x.type = "password";
                                    icon.classList.remove("fa-eye-slash");
                                    icon.classList.add("fa-eye");
                                }
                            }
</script>
<!-- Content End -->
@endsection
