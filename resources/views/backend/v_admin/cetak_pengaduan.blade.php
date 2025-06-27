<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; border: 1px solid #ccc; }
        table tr td, table th { padding: 6px; font-weight: normal; border: 1px solid #ccc; text-align: left; }
        .header-table td { border: none; text-align: center; padding-bottom: 0; }
        .info-table td { border: none; padding-top: 0; padding-bottom: 10px; }
        .judul { font-size: 22px; font-weight: bold; margin-bottom: 10px; }
        .subjudul { font-size: 16px; margin-bottom: 20px; }
        .label { font-weight: bold; }
    </style>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">
</head>
<body>

    <!-- Watermark Logo -->
    <img src="{{ asset('image/logo.png') }}" class="watermark" alt="Logo">

    <div class="content">
        <center>
            <h3>Aplikasi {{$nama_aplikasi}}</h3>
        </center>

        <h4>{{ $judul }}</h4>
        <p>Periode: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</p>
        <p>Total Data: <b>{{ $total }}</b></p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Nama Pengadu</th>
                    <th>Lokasi</th>
                    <th>Nomor HP</th>
                    <th>Tanggal Pengaduan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $p)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $p->judul }}</td>
                    <td>{{ $p->user->nama ?? '-' }}</td>
                    <td>{{ $p->lokasi }}</td>
                    <td>{{ $p->user->no_hp ?? '-' }}</td>
                    <td>{{ $p->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
