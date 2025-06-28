{{-- Hapus seluruh kode PHP native di atas DOCTYPE --}}

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        {{-- Logo Aplikasi --}}
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">
        {{-- Font Poppins --}}
        <link rel="stylesheet" href="{{ asset('font/poppins-font.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Register Page</title>
        <style>
            body {
                background-color: #1f262d !important;
            }
            .card {
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus laborum quas, eum facilis obcaecati nemo placeat molestiae, quo dolorum sapiente nobis voluptas commodi qui amet atque ad odio, pariatur rem.
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white text-center">
                        {{-- <img src="{{ asset('image/logo.png') }}" alt="Logo" width="150" class="d-inline-block align-text-top circle"> --}}
                        <h3 class="text-center">SIADU</h3>
                    </div>
                    {{-- Pesan error --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <h3 class="text-center">Daftar</h3>
                        <form action="{{ route('backend.register') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="d-flex gap-1" for="nik_user">NIK<p style="color: red">* (Max 16 Angka)</p></label>
                                <input type="number" class="form-control @error('nik') is-invalid @enderror" id="nik_user" name="nik" placeholder="Masukan NIK anda">
                                @error('nik')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-flex gap-1" for="nama_lengkap">Nama<p style="color: red">*</p></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_lengkap" name="nama" placeholder="Masukan nama lengkap anda">
                                @error('nama')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-flex gap-1" for="no_telp">No.Telepon<p style="color: red">* (Max 13 Angka)</p></label>
                                <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_telp" name="no_hp" placeholder="0895.....">
                                @error('no_hp')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-flex gap-1" for="email">Email<p style="color: red">*</p></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukan email">
                                @error('email')
                                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-flex gap-1" for="password">Password<p style="color: red">*</p></label>
                                <div class="password-input-wrapper d-flex justify-content-center align-items-center gap-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="passwordInput" name="password" placeholder="Masukan password">
                                    <span class="fa fa-eye password-icon" aria-hidden="true" onclick="showPassword()"></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback alert-danger" role="alert" style="display:block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="d-flex gap-1" for="confirm_password">Konfirmasi Password<p style="color: red">*</p></label>
                                <div class="password-input-wrapper" style="position: relative;">
                                    <input type="password" class="form-control" id="confirmPasswordInput" name="password_confirmation" placeholder="Masukan password lagi">
                                </div>
                            </div>
                            <div id="debugContent" class="alert alert-info fade-in" style="display: none;">
                                <div class="form-group">
                                    <center>
                                        <p>(Developer Mode ON)</p>
                                    </center>
                                    <label for="role">Akun sebagai</label>
                                    <select class="form-select" name="role" id="role">
                                        <option value="0" selected>User</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                                <center>
                                    <button type="button" id="turnOffDebugBtn" class="btn btn-danger mt-3">
                                        Turn Off Developer Mode
                                    </button>
                                </center>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block w-100">Register</button>
                        </form>
                        <p class="mt-3 text-center">Sudah punya akun? <a class="text-decoration-none" href="{{ route('backend.login') }}">Login</a></p>
                    </div>
                </div>
            </div>
            {{-- Footer tetap --}}
            @include('components.footer')
        </div>
    </div>

    <script>
    function showPassword() {
        var x = document.getElementById("passwordInput");
        var y = document.getElementById("confirmPasswordInput");
        var icon = document.querySelector(".password-icon");
        if (x.type === "password") {
            x.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
        if (y.type === "password") {
            y.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            y.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
    </script>
    <style>
    .form-group .password-input-wrapper {
        position: ;
    }
    .form-group .password-input-wrapper input {
        /* padding-right: 35px; */
    }
    .form-group .password-icon {
        /* position: absolute;
        top: 50%;
        right: 10px; */
        vertical-align: middle
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 2;
    }
    </style>
    </body>
</html>
