<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kode OTP SIADU</title>
</head>
<body>
    <h2>Halo, {{ $nama }}</h2>
    <p>Kode OTP Anda untuk verifikasi SIADU adalah:</p>
    <h1 style="letter-spacing: 10px; font-size: 2.5em;">{{ $otp_code }}</h1>
    <p>Kode ini berlaku selama 5 menit.</p>
    <p>Jika Anda tidak meminta kode ini, abaikan email ini.</p>
    <br>
    <p>Salam,<br>SIADU Team</p>
</body>
</html>
