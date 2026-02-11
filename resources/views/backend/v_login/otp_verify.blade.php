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
     <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">

    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.min.js') }}"></script>

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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Verifikasi OTP</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif
                        <form method="POST" action="{{ route('otp.verify.process') }}" autocomplete="off">
                            @csrf
                            <div class="form-group text-center">
                                <label for="otp">Masukkan 6 Digit Kode OTP</label>
                                <div class="d-flex justify-content-center mt-3 mb-4">
                                    @for($i=0; $i<6; $i++)
                                        <input type="text" name="otp[]" maxlength="1" pattern="[0-9]*" inputmode="numeric" class="form-control mx-1 text-center otp-input" style="width: 45px; height: 45px; font-size: 1.5em;" required>
                                    @endfor
                                </div>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary btn-block">Verifikasi</button>
                            </center>
                        </form>
                        <div class="text-center mt-3">
                            <small>Kode OTP telah dikirim ke email Anda.</small>
                            {{-- <br>
                            <br>
                            <button class="btn btn-sml btn-secondary" type="button">Kirim OTP</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Handle OTP inputs: single-digit, auto-move, backspace and paste split
        (function() {
            const inputs = Array.from(document.querySelectorAll('.otp-input'));

            inputs.forEach((input, idx) => {
                input.addEventListener('input', (e) => {
                    // keep only digits and only first char
                    input.value = input.value.replace(/\D/g, '').slice(0,1);
                    if (input.value && idx < inputs.length - 1) {
                        inputs[idx + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace') {
                        if (input.value === '' && idx > 0) {
                            inputs[idx - 1].focus();
                        } else {
                            // allow deleting current value
                            input.value = '';
                        }
                        // prevent default so we control focus/clearing
                        e.preventDefault();
                    } else if (e.key.length === 1 && /\d/.test(e.key)) {
                        // allow digit keys (will be handled in input event)
                    } else if (e.key !== 'Tab' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
                        // block non-numeric non-control keys
                        // allow navigation keys
                        if (!e.ctrlKey && !e.metaKey) e.preventDefault();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text') || '';
                    const digits = paste.replace(/\D/g, '').split('');
                    if (digits.length === 0) return;
                    for (let i = 0; i < digits.length && (idx + i) < inputs.length; i++) {
                        inputs[idx + i].value = digits[i];
                    }
                    const focusIndex = Math.min(idx + digits.length, inputs.length - 1);
                    inputs[focusIndex].focus();
                });
            });
        })();
    </script>

</body>

</html>
