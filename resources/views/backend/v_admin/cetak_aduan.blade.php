<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aduan</title>
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
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td>
                <img src="{{ asset('image/logo.png') }}" width="15%">
                <div class="judul">SIADU</div>
                <div class="subjudul">Laporan Detail Pengaduan</div>
            </td>
        </tr>
    </table>

    <!-- Info Section -->
    <table class="info-table">
        <tr>
            <td>
                <span class="label">Tanggal Lapor:</span> {{ $aduan->tanggal_lapor }}<br>
                <span class="label">Status:</span> {{ ucfirst($aduan->status) }}<br>
                <span class="label">Kategori:</span> {{ $aduan->kategori }}<br>
                <span class="label">Lokasi:</span> {{ $aduan->lokasi }}<br>
            </td>
        </tr>
    </table>

    <!-- Data Aduan -->
    <table>
        <tr>
            <tr>
                <th>Judul</th>
                <td>{{ $aduan->judul }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $aduan->deskripsi }}</td>
            </tr>
            <th>Foto Aduan</th>
            <td>
                <center>
                    @if($aduan->foto)
                        <img src="{{ asset('storage/img-pengaduan/' . $aduan->foto) }}" alt="Foto Aduan" style="max-width:300px;">
                    @else
                        <span>-</span>
                    @endif
                </center>
            </td>
        </tr>
        <tr>
            <th>Nama Pelapor</th>
            <td>{{ $aduan->user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Email Pelapor</th>
            <td>{{ $aduan->user->email ?? '-' }}</td>
        </tr>
        <tr>
            <th>No HP Pelapor</th>
            <td>{{ $aduan->user->no_hp ?? '-' }}</td>
        </tr>
    </table>

    <script>
    window.onload = function() {
        printStruk();
    }

    function printStruk() {
        window.print();
    }
</script>
</body>
</html>
