@extends('backend.v_layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card mt-4">
                <div class="card-header">
                    <h2>Detail Tindak Lanjut</h2>
                </div>
                <div class="card-body">
                    <h4><b>Judul Aduan:</b> {{ $tindak->pengaduan->judul }}</h4>
                    <hr>
                    <p><b>Ditangani oleh:</b>
                        @if ($tindak->petugas->foto)
                            <img src="{{ asset('storage/img-user/' . $tindak->petugas->foto) }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                        @else
                            <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                        @endif
                        {{ $tindak->petugas->nama ?? '-' }}
                    </p>
                    <p><b>Instansi:</b>
                        @if ($tindak->petugas->instansi)
                            <span class="badge badge-info">{{ $tindak->petugas->instansi }}</span>
                        @else
                            <span class="badge badge-dark">Belum ada instansi</span>
                        @endif
                    </p>
                    <p><b>Tanggal Tindakan:</b> {{ $tindak->tanggal_tindak }}</p>
                    <p style="text-wrap: ;"><b>Catatan:</b> {{ $tindak->catatan }}</p>
                    <p><b>Status Akhir:</b>
                        <span class="badge {{ $tindak->status_akhir == 'selesai' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($tindak->status_akhir) }}
                        </span>
                    </p>
                    <p><b>Bukti Penanganan:</b></p>
                    @if($tindak->foto)
                        <a href="{{ asset('storage/img-tindaklanjut/' . $tindak->foto) }}" target="_blank" class="btn btn-info btn-sm mb-2">
                            Lihat Foto
                        </a>
                        <br>
                        <img src="{{ asset('storage/img-tindaklanjut/' . $tindak->foto) }}" alt="Bukti Penanganan" class="img-fluid border" style="max-width: 300px;">
                    @else
                        <span class="text-muted">Tidak ada foto penanganan.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
