@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <h3>Tindak Lanjut Belum Selesai</h3>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Pengaduan</th>
                        <th>Petugas/Admin</th>
                        <th>Tanggal Tindak</th>
                        <th>Status Akhir</th>
                        <th>Catatan</th>
                        <th>Foto</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tindaklanjut as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->pengaduan->judul }}</td>
                        <td class="d-flex align-items-center" style="gap: 10px">
                            @if ($t->petugas->foto)
                                <img src="{{ asset('storage/img-user/' . $t->petugas->foto) }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                            @else
                                <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                            @endif
                            <span>{{ $t->petugas->nama }}</span>
                        </td>
                        <td>{{ $t->tanggal_tindak }}</td>
                        <td>
                            <span class="badge badge-warning">
                                {{ ucfirst($t->status_akhir) }}
                            </span>
                        </td>
                        <td>{{ $t->catatan }}</td>
                        <td>
                            @if($t->foto)
                                <a href="{{ asset('storage/img-tindaklanjut/' . $t->foto) }}" target="_blank" class="btn btn-info btn-sm mb-1">
                                    Lihat Foto
                                </a>
                                <br>
                                <img src="{{ asset('storage/img-tindaklanjut/' . $t->foto) }}" width="60">
                            @else
                                <center>
                                    <h1>-</h1>
                                </center>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('backend.admin.detailaduan', $t->pengaduan->id_pengaduan) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-chat-right-text-fill"></i> Chat
                            </a>
                            {{-- <form action="{{ route('backend.admin.tindaklanjut.destroy', $t->id_tindak) }}" method="POST" class="form-hapus-tindaklanjut" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-hapus-tindaklanjut"><i class="bi bi-trash3-fill"></i> Hapus</button>
                            </form> --}}
                            <a href="{{ route('backend.admin.detail_tindaklanjut', $t->id_tindak) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a>
                        </td>
                        {{-- <td>
                            <a href="{{ route('backend.admin.detailaduan', $t->pengaduan->id_pengaduan) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('backend.admin.detail_tindaklanjut', $t->id_tindak) }}" class="btn btn-info btn-sm">Detail</a>
                        </td> --}}
                    </tr>
                    @endforeach
                    @if($tindaklanjut->isEmpty())
                        <tr><td colspan="8" class="text-center">Tidak ada tindak lanjut yang belum selesai.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
