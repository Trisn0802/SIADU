<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kode OTP SIADU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-code {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 2.5em;
            letter-spacing: 10px;
            margin: 20px 0;
            font-weight: bold;
        }
        .verify-button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            cursor: pointer;
        }
        .verify-button:hover {
            background-color: #218838;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .info {
            background-color: #e7f3ff;
            padding: 10px;
            border-left: 4px solid #007bff;
            margin: 15px 0;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Halo, {{ $nama }}👋</h2>
        </div>

        <p>Kode OTP Anda untuk verifikasi SIADU adalah:</p>

        <div class="otp-code">{{ $otp_code }}</div>

        <div class="info">
            <strong>⏱️ Perhatian:</strong> Kode ini berlaku selama 5 menit
        </div>

        <p style="text-align: center; margin: 20px 0;">
            <a href="{{ route('otp.verify.form') }}" class="verify-button">
                🔐 Verifikasi OTP Sekarang
            </a>
        </p>

        <p>Atau, copy-paste kode di atas ke halaman verifikasi.</p>

        <div class="info">
            ⚠️ <strong>Keamanan:</strong> Jangan bagikan kode ini kepada siapapun!<br>
            Jika Anda tidak meminta kode ini, abaikan email ini.
        </div>

        <div class="footer">
            <p>Salam,<br><strong>SIADU Team</strong></p>
            <p style="font-size: 11px; margin-top: 15px;">
                © 2025 SIADU - Sistem Informasi Aduan Masyarakat<br>
                Email ini dikirim secara otomatis, jangan balas email ini.
            </p>
        </div>
    </div>
</body>
</html>
