<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Petugas & Admin</title>
    <style>
        body { font-family: Arial, sans-serif; position: relative; }
        table { border-collapse: collapse; width: 100%; border: 1px solid #ccc; }
        table tr td, table th { padding: 6px; font-weight: normal; border: 1px solid #ccc; text-align: left; }
        .header-table td { border: none; text-align: center; padding-bottom: 0; }
        .info-table td { border: none; padding-top: 0; padding-bottom: 10px; }
        .judul { font-size: 22px; font-weight: bold; margin-bottom: 10px; }
        .subjudul { font-size: 16px; margin-bottom: 20px; }
        .label { font-weight: bold; }

        /* Watermark logo */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 350px;
            height: 350px;
            opacity: 0.10;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
            user-select: none;
        }
        .content {
            position: relative;
            z-index: 1;
        }
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Instansi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $u)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $u->nama }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->no_hp }}</td>
                    <td>{{ $u->instansi ?? '-' }}</td>
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
