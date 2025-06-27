<body style="margin:0; padding:0; font-family: 'Segoe UI', Arial, sans-serif;">
    <div style="max-width:500px; margin:50px auto; background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); padding:32px 32px 24px 32px;">
        <div style="text-align:center; margin-bottom:24px;">
            <img src="https://i.ibb.co/mpdPwG4/logo.png" alt="Logo" width="80" height="80" style="border-radius:50%; object-fit: cover;">
        </div>
        <div style="font-size:1.15rem; color:#4b2354; font-weight:600; margin-bottom:18px; text-align:center;">
            Pengaduan Anda ditanggapi <span style="color:#4b2354; font-weight:700;">{{ $penanggap ?? 'Petugas/Admin' }}</span>
        </div>
        <div style="background:#f5f7fa; border-left:4px solid #aad2ef; padding:18px 20px; margin-bottom:18px; color:#333; font-size:1.05rem;">
            <span style="font-style:italic;">
                Judul Pengaduan: <b>{{ $judulPengaduan ?? $judul }}</b>
            </span>
        </div>
        <div style="background:#f5f7fa; border-left:4px solid #b39ddb; padding:18px 20px; margin-bottom:18px; color:#333; font-size:1.05rem;">
            <span style="font-style:italic;">"{{ $pesan }}"</span>
        </div>
        @if($url)
        <div style="text-align:center; margin-bottom:18px;">
            <a href="{{ $url }}" style="display:inline-block; background:#4b2354; color:#fff; padding:10px 24px; border-radius:6px; text-decoration:none; font-weight:600;">
                Lihat Detail
            </a>
        </div>
        @endif
        <div style="color:#888; font-size:0.95rem; margin-bottom:18px;">
            {{ $tanggal ?? \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}
        </div>
        <div style="color:#4b2354; font-size:1rem; margin-bottom:8px;">
            Terima kasih,<br>
            <span style="font-weight:600;">{{$role}} | SIADU </span>
        </div>
        <div style="text-align:center; color:#aaa; font-size:0.95rem; margin-top:18px;">
            &copy; {{ date('Y') }} SIS-SIADU.
        </div>
    </div>
</body>

