@extends('backend.v_layouts.app')

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
                <form action="{{ route('backend.petugas.updatepassword') }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{$judul}}</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 offset-md-4 card border mt-3">
                                <div class="text-center mb-3 mt-3">
                                    <img src="{{ $edit->foto ? asset('storage/img-user/' . $edit->foto) : asset('storage/img-user/img-default.jpg') }}"
                                        alt="Foto Profil"
                                        class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #eee;">
                                    <h5 class="mt-3">{{ $edit->nama }}</h5>
                                </div>
                                <div class="form-group">
                                    <label>Password Lama</label>
                                    <span class="fa fa-eye password-icon-1" aria-hidden="true" onclick="showPasswordLama()"></span>
                                    <input type="password" id="passwordInputLama" name="password_lama" class="form-control @error('password_lama') is-invalid @enderror" placeholder="Masukkan password lama Anda">
                                    @error('password_lama')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <span class="fa fa-eye password-icon-2" aria-hidden="true" onclick="showPasswordBaru()"></span>
                                    <input type="password" id="passwordInputBaru" name="password_baru" class="form-control @error('password_baru') is-invalid @enderror" placeholder="Masukkan password baru Anda">
                                    @error('password_baru')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <span class="fa fa-eye password-icon-3" aria-hidden="true" onclick="showPasswordKonfirmasi()"></span>
                                    <input type="password" id="passwordInputKonfirmasi" name="password_baru_confirmation" class="form-control @error('password_baru') is-invalid @enderror" placeholder="Masukkan konfirmasi password">
                                </div>
                            </div>
                        </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-info">Ganti Password</button>
                            <a href="{{ route('backend.petugas.edit') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Skrip untuk hide dan un hide input password --}}
<script>
                            function showPasswordLama() {
                                var x = document.getElementById("passwordInputLama");
                                var icon = document.querySelector(".password-icon-1");
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
