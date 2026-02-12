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
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .password-toggle {
        cursor: pointer;
        color: #6c757d;
    }
    .password-toggle:hover {
        color: #007bff;
    }
</style>

<!-- Content Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('password.change.process', ['uuid' => $user->uuid]) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ✓ {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ✗ {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>✗ Terjadi Kesalahan:</strong>
                                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Password Lama <span class="text-danger">*</span></label>
                                    <div class="password-input-wrapper">
                                        <input
                                            type="password"
                                            name="password_lama"
                                            class="form-control @error('password_lama') is-invalid @enderror"
                                            placeholder="Masukkan password lama Anda"
                                            id="passwordLama"
                                            required
                                        >
                                        <span class="fa fa-eye password-toggle" onclick="togglePassword('passwordLama')"></span>
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle"></i> Password lama diperlukan untuk keamanan akun Anda
                                    </small>
                                    @error('password_lama')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <hr class="my-4">

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Password Baru <span class="text-danger">*</span></label>
                                    <div class="password-input-wrapper">
                                        <input
                                            type="password"
                                            name="password_baru"
                                            class="form-control @error('password_baru') is-invalid @enderror"
                                            placeholder="Masukkan password baru (minimal 8 karakter)"
                                            id="passwordBaru"
                                            required
                                            min="8"
                                            onkeyup="checkPasswordStrength()"
                                        >
                                        <span class="fa fa-eye password-toggle" onclick="togglePassword('passwordBaru')"></span>
                                    </div>
                                    <div class="password-strength">
                                        <div class="password-strength-bar" id="strengthBar"></div>
                                    </div>
                                    <small id="strengthText" class="d-block mt-2">Kekuatan password</small>
                                    @error('password_baru')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <div class="password-input-wrapper">
                                        <input
                                            type="password"
                                            name="password_baru_confirmation"
                                            class="form-control @error('password_baru_confirmation') is-invalid @enderror"
                                            placeholder="Ulangi password baru"
                                            id="passwordBaruConfirm"
                                            required
                                        >
                                        <span class="fa fa-eye password-toggle" onclick="togglePassword('passwordBaruConfirm')"></span>
                                    </div>
                                    <small class="text-muted d-block mt-2">Harus sama dengan password baru</small>
                                    @error('password_baru_confirmation')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="alert alert-info mt-4" role="alert">
                                    <strong><i class="fas fa-lightbulb"></i> Tips Password Aman:</strong>
                                    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                                        <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</li>
                                        <li>Minimal 8 karakter</li>
                                        <li>Jangan gunakan informasi pribadi (nama, tanggal lahir, dll)</li>
                                        <li>Hindari password yang mudah ditebak</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body mobile-btn">
                            <button type="submit" class="btn btn-primary auto-width-btn">Ubah Password</button>
                            <a href="{{ route('password.forgot.form.change', ['uuid' => $user->uuid]) }}" class="btn btn-warning auto-width-btn">Lupa Password?</a>

                            @if($userType === 'petugas')
                                <a href="{{ route('backend.petugas.dashboard') }}" class="btn btn-secondary auto-width-btn">Kembali</a>
                            @elseif($userType === 'admin')
                                <a href="{{ route('backend.user.showUser') }}" class="btn btn-secondary auto-width-btn">Kembali</a>
                            @else
                                <a href="{{ route('backend.beranda.user') }}" class="btn btn-secondary auto-width-btn">Kembali</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Content End -->

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = event.target;

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength() {
    const password = document.getElementById('passwordBaru').value;
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
        strengthText.innerHTML = '<i class="fas fa-times-circle"></i> <span style="color: #dc3545;">Lemah</span>';
    } else if (strength < 70) {
        strengthBar.style.backgroundColor = '#ffc107';
        strengthText.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span style="color: #ffc107;">Sedang</span>';
    } else {
        strengthBar.style.backgroundColor = '#28a745';
        strengthText.innerHTML = '<i class="fas fa-check-circle"></i> <span style="color: #28a745;">Kuat</span>';
    }
}
</script>
@endsection
