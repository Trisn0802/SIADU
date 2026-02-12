<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">

    {{-- Font Poppins --}}
    <link rel="stylesheet" href="{{ asset('font/poppins-font.css') }}">

    <title>SIADU - Lupa Password</title>
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Poppins', Arial, Helvetica, sans-serif;
    }
    .auth-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
    }
    .auth-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }
    .auth-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 30px 20px;
        text-align: center;
    }
    .auth-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }
    .auth-header p {
        margin: 10px 0 0 0;
        font-size: 14px;
        opacity: 0.9;
    }
    .auth-body {
        padding: 40px 30px;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }
    .form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }
    .form-group input.is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }
    .btn-container {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }
    .btn {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.3);
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }
    .info-box {
        background-color: #e7f3ff;
        border-left: 4px solid #007bff;
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 5px;
        color: #004085;
        font-size: 14px;
        line-height: 1.5;
    }
    .alert {
        padding: 12px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
</style>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>🔐 Lupa Password</h2>
                <p>SIADU - Sistem Informasi Aduan</p>
            </div>

            <div class="auth-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        ✗ Terjadi kesalahan. Silakan coba lagi.
                    </div>
                @endif

                <div class="info-box">
                    <strong>📧 Masukkan email Anda</strong><br>
                    Kami akan mengirimkan link untuk mereset password Anda ke email yang terdaftar.
                </div>

                <form action="{{ route('password.send.reset.link') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Terdaftar</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email Anda"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
                        <a href="{{ route('backend.login') }}" class="btn btn-secondary">Kembali ke Login</a>
                    </div>
                </form>

                <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #eee; font-size: 13px; color: #666; text-align: center;">
                    <p style="margin: 5px 0;">
                        <strong>💡 Tips Keamanan:</strong><br>
                        Jangan pernah bagikan link reset password Anda kepada siapapun. Link ini hanya berlaku selama 1 jam.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>

</html>
