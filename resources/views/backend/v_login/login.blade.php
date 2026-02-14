<div style="display: none;">
</div>

<!DOCTYPE html>
<html>
    {{-- aktifkan tema --}}
{{-- <html data-bs-theme="auto"> --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
     <!-- CSS Boostrap -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    {{-- Logo Aplikasi --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">
    {{-- Font Poppins --}}
    <link rel="stylesheet" href="{{ asset('font/poppins-font.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login Page</title>
    <style>
        body {
            background-color: #1f262d !important;
        }
        .container{
            /* display: grid;
            place-items: center; */
        }
        .alert {
            word-break: break-word;
            white-space: pre-line;
            max-width: 100%;
            padding: -3px;
        }
        .card {
            /* max-width: 430px; */
            margin: 0 auto;
            /* margin-left: auto;
            margin-right: auto; */
            /* display: grid;
            place-items: center; */
        }
    </style>
</head>

<body>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center">
            @if(!empty($announcement) && $announcement->is_active && !empty($announcement->content))
            <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                <div class="card border-warning h-100">
                    <div class="card-header bg-warning text-white text-center">
                        <h5 class="mb-0 text-dark">Pemberitahuan</h5>
                    </div>
                    {{-- <div class="bg-dark" style="height: 14px;"></div> --}}
                    <div class="card-body">
                        <div class="announcement-content">{!! $announcement->content !!}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
            @else
            <div class="col-lg-12 col-md-12 col-sm-12">
            @endif
                <div class="card border-primary mx-auto w-100" style="max-width:500px;">
                    <div class="card-header bg-primary text-white text-center">
                        <div class="mb-2">
                            {{-- <img src="{{ asset('image/logo.png') }}" alt="Logo" width="150" class="" style="border-radius: 100%;"> --}}
                            {{-- <img src="{{ asset('image/logo.png') }}" alt="Logo" width="150" class="d-inline-block align-text-top"> --}}
                            <h3>SIADU</h3>
                        </div>
                    <div style="background: #212121; color: White; border-radius: 10px;">
                    <script type='text/javascript'>
                                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                                    var date = new Date();
                                    var day = date.getDate();
                                    var month = date.getMonth();
                                    var thisDay = date.getDay(),
                                        thisDay = myDays[thisDay];
                                    var yy = date.getYear();
                                    var year = (yy < 1000) ? yy + 1900 : yy;
                                    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                    </script>
                    </div>
                </div>

                {{-- pesan error --}}
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- pesan error 2 --}}
                @if(session()->has('error2'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <div>{{ session('error2') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- pesan warning --}}
                @if(session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                        <div>{{ session('warning') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Pesan sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-body">
                    {{-- @if(!empty($announcement) && $announcement->is_active && !empty($announcement->content))
                        <div class="alert alert-info mb-4" style="background:#e7f3fe; border-color:#bee5eb; color:#0c5460;">
                            <div class="fw-bold mb-2">Pemberitahuan</div>
                            <div class="announcement-content">{!! $announcement->content !!}</div>
                        </div>
                    @endif --}}
                    <h3 class="text-center">Login</h3>
                    <form method="POST" action="{{ route('backend.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukan email anda"
                                {{-- required --}}
                                >
                            @error('email')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <br>
                        <div class="form-group" style="position: relative;">
                            <label for="password">Password</label>
                            <div class="password-input-wrapper d-flex justify-content-center align-items-center gap-3">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="passwordInput"
                                    name="password"
                                    placeholder="Masukan password anda"
                                    {{-- required --}}
                                    >
                                <span class="fa fa-eye password-icon" aria-hidden="true" onclick="showPassword()"></span>
                            </div>
                            @error('password')
                                    <span class="invalid-feedback alert-danger" role="alert" style="display:block; word-break: break-word; white-space: pre-line;">
                                        {{ $message }}
                                    </span>
                            @enderror
                        </div>
                        <style>
                            .form-group .password-input-wrapper {
                                /* position: ; */
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
                        <script>
                            function showPassword() {
                                var x = document.getElementById("passwordInput");
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
                            }
                        </script>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block w-100 mt-3">Login</button>
                        <button type="button" class="btn btn-secondary btn-block w-100 mt-3" onclick="window.location='{{ route('landing.page') }}'">Home</button>
                        <p class="mt-3 text-center">
                            <a class="text-decoration-none" href="{{ route('password.forgot.form') }}">Lupa Password?</a> |
                            <a class="text-decoration-none" href="{{ route('backend.register') }}">Daftar disini</a>
                        </p>
                        <hr class="my-3">
                        <p class="text-center mb-2">
                            <small class="text-muted">Sudah memiliki kode OTP?</small>
                        </p>
                        <button type="button" class="btn btn-outline-primary btn-block w-100" onclick="window.location='{{ route('otp.verify.form') }}'">
                            Verifikasi OTP
                        </button>
                    </form>
                </div>
            </div>
            @if(!empty($announcement) && $announcement->is_active && !empty($announcement->content))
            @endif
        </div>
        {{-- Footer tetap --}}
    @include('components.footer')
    </div>
    <!-- <script src="assets/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>


