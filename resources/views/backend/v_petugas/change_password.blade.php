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

        <title>SIADU - Ganti Password Petugas</title>
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
            min-height: 50vh;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
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
            background: linear-gradient(135deg, #17a2b8 0%, #0c5460 100%);
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
            border-color: #17a2b8;
            box-shadow: 0 0 0 3px rgba(23,162,184,0.1);
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
        .btn-info {
            background-color: #17a2b8;
            color: white;
        }
        .btn-info:hover {
            background-color: #0c5460;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23,162,184,0.3);
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
            background-color: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
            color: #0c5460;
            font-size: 14px;
            line-height: 1.5;
        }
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s, background-color 0.3s;
        }
        .password-input-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }
        .password-icon {
            cursor: pointer;
            color: #666;
        }
    </style>

    <body>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>🔐 Ganti Password</h2>
                    <p>SIADU - Petugas</p>
                </div>

                <div class="auth-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            ✓ {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            ✗ Terjadi kesalahan:
                            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="info-box">
                        <strong>👤 Pengguna: {{ $user->nama }}</strong> (Petugas)<br>
                        Masukkan password lama dan password baru Anda di bawah ini.
                    </div>

                    <form action="{{ route('backend.petugas.updatepassword') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="password_lama">Password Lama</label>
                            <div class="password-input-wrapper">
                                <input
                                    type="password"
                                    id="password_lama"
                                    name="password_lama"
                                    class="form-control @error('password_lama') is-invalid @enderror"
                                    placeholder="Masukkan password lama"
                                    required
                                >
                                <i class="bi bi-eye password-icon" onclick="togglePassword('password_lama', this)"></i>
                            </div>
                            @error('password_lama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_baru">Password Baru (Min 8 Karakter)</label>
                            <div class="password-input-wrapper">
                                <input
                                    type="password"
                                    id="password_baru"
                                    name="password_baru"
                                    class="form-control @error('password_baru') is-invalid @enderror"
                                    placeholder="Masukkan password baru"
                                    required
                                    onkeyup="checkPasswordStrength()"
                                >
                                <i class="bi bi-eye password-icon" onclick="togglePassword('password_baru', this)"></i>
                            </div>
                            <div class="password-strength" style="margin-top: 8px;">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <small id="strengthText" style="color: #666;"></small>
                            @error('password_baru')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                            <div class="password-input-wrapper">
                                <input
                                    type="password"
                                    id="password_baru_confirmation"
                                    name="password_baru_confirmation"
                                    class="form-control @error('password_baru_confirmation') is-invalid @enderror"
                                    placeholder="Konfirmasi password baru"
                                    required
                                >
                                <i class="bi bi-eye password-icon" onclick="togglePassword('password_baru_confirmation', this)"></i>
                            </div>
                        </div>

                        <div class="btn-container">
                            <button type="submit" class="btn btn-info">Ganti Password</button>
                            <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>

                    <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #eee; font-size: 13px; color: #666;">
                        <p style="margin: 5px 0;">
                            <strong>💡 Tips Password Aman:</strong><br>
                            • Gunakan kombinasi huruf, angka, dan simbol<br>
                            • Minimal 8 karakter<br>
                            • Hindari password yang mudah ditebak<br>
                            • Jangan gunakan informasi pribadi
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script>
        function togglePassword(fieldId, iconElem) {
            const input = document.getElementById(fieldId);
            if (!input || !iconElem) return;
            if (input.type === 'password') {
                input.type = 'text';
                iconElem.classList.remove('bi-eye');
                iconElem.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                iconElem.classList.remove('bi-eye-slash');
                iconElem.classList.add('bi-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password_baru').value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            let strength = 0;

            if (password.length >= 8) strength += 20;
            if (password.length >= 12) strength += 20;
            if (/[a-z]/.test(password)) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 10;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 10;

            strength = Math.min(strength, 100);
            strengthBar.style.width = strength + '%';

            if (strength < 40) {
                strengthBar.style.backgroundColor = '#dc3545';
                strengthText.textContent = '❌ Lemah';
                strengthText.style.color = '#dc3545';
            } else if (strength < 70) {
                strengthBar.style.backgroundColor = '#ffc107';
                strengthText.textContent = '⚠️ Cukup';
                strengthText.style.color = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
                strengthText.textContent = '✓ Kuat';
                strengthText.style.color = '#28a745';
            }
        }
        </script>
    </body>

    </html>
