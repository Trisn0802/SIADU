@extends('backend.v_layouts.app')

@section('content')
<style>
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
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
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
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>🔐 Reset Password</h2>
            <p>SIADU - Sistem Informasi Aduan</p>
        </div>

        <div class="auth-body">
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
                <strong>📧 Email: {{ $email }}</strong><br>
                Masukkan password baru Anda di bawah ini.
            </div>

            <form action="{{ route('password.reset.process') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="password">Password Baru Minimal 8 Karakter</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password baru"
                        required
                        min="8"
                        onkeyup="checkPasswordStrength()"
                    >
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    <small id="strengthText" style="color: #666;"></small>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Konfirmasi password baru"
                        required
                    >
                    @error('password_confirmation')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                    <a href="{{ route('backend.login') }}" class="btn btn-secondary">Kembali</a>
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

<script>
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
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
@endsection
