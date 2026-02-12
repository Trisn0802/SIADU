<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIADU</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
            color: #333;
        }
        .content h2 {
            color: #0056b3;
            margin-top: 0;
        }
        .content p {
            line-height: 1.6;
            margin: 10px 0;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            color: #856404;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
        }
        .token-info {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            word-break: break-all;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Reset Password</h1>
            <p>SIADU - Sistem Informasi Aduan</p>
        </div>

        <div class="content">
            <h2>Halo {{ $user->nama }},</h2>

            <p>Kami menerima permintaan untuk mereset password akun Anda. Jika Anda tidak melakukan permintaan ini, abaikan email ini dan password Anda akan tetap aman.</p>

            <p>Untuk melanjutkan proses reset password, silakan klik tombol di bawah ini:</p>

            <div class="button-container">
                <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            </div>

            <p style="text-align: center; color: #666; font-size: 12px;">Atau salin link ini ke browser Anda:</p>
            <div class="token-info">
                {{ $resetUrl }}
            </div>

            <div class="warning">
                <strong>⚠️ Perhatian!</strong>
                <p>Link reset password ini hanya berlaku selama <strong>1 jam</strong>. Jika link sudah kadaluarsa, silakan ajukan permintaan reset password baru.</p>
            </div>

            <p style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; font-size: 12px; color: #666;">
                <strong>Informasi Keamanan:</strong><br>
                - Link ini hanya berlaku untuk 1 jam dari waktu pengiriman email<br>
                - Jangan bagikan link ini kepada siapapun<br>
                - Pastikan Anda mengganti password dengan yang kuat<br>
                - Password minimal 8 karakter dengan kombinasi angka dan huruf
            </p>
        </div>

        <div class="footer">
            <p><strong>SIADU - Sistem Informasi Aduan Umum</strong></p>
            <p>Email ini dikirim karena ada permintaan reset password pada akun dengan email {{ $user->email }}</p>
            <p>&copy; {{ date('Y') }} SIADU. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
