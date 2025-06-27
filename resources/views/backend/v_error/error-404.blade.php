<!DOCTYPE html>
<html dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/HakimNet-icon.svg') }}">
        <title>
            @error('recordNotFound')
                {{ $message }}
            @else
                {{ config('app.name') }} - 404 Not Found
            @enderror
        </title>
        <!-- Custom CSS -->
        <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">

    </head>

    <body>
        <div class="main-wrapper" style="margin-top: 100px;">
            <!-- ============================================================== -->
            <!-- Preloader - style you can find in spinners.css -->
            <!-- ============================================================== -->
            {{-- <div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div> --}}
            <!-- ============================================================== -->
            <!-- Preloader - style you can find in spinners.css -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Login box.scss -->
            <!-- ============================================================== -->
            <div class="error-box">
                <div class="error-body text-center">
                    <h1 class="error-title text-danger">404</h1>
                    <h3 class="text-uppercase error-subtitle">PAGE NOT FOUND !</h3>
                    @if (session('error'))
                        <p class="text-muted m-t-30 m-b-30" style="font-weight: bold;">{{ session('error') }}</p>
                    @elseif (session('message'))
                        <p class="text-muted m-t-30 m-b-30" style="font-weight: bold;">{{ session('message') }}</p>
                    @else
                        <p class="text-muted m-t-30 m-b-30" style="font-weight: bold;">Halaman yang kamu tuju mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.</p>
                    @endif

                    @if(auth()->user()->role == 0)
                        <a href="{{ route('backend.beranda.user') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Kembali ke home</a>
                    @elseif (auth()->user()->role == 1)
                        <a href="{{ route('backend.beranda') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Kembali ke home</a>
                    @elseif (auth()->user()->role == 2)
                        <a href="{{ route('backend.beranda') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Kembali ke home</a>
                    @else
                        <a href="{{ route('backend.login') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Kembali ke login</a>
                    @endif
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Login box.scss -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper scss in scafholding.scss -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper scss in scafholding.scss -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right Sidebar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right Sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- All Required js -->
        <!-- ============================================================== -->
        <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- ============================================================== -->
        <!-- This page plugin js -->
        <!-- ============================================================== -->
        <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        </script>
    </body>

</html>
