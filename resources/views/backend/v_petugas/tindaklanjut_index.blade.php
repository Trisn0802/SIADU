@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <h3>{{$judul}}</h3>
    {{-- <a href="{{ route('backend.tindaklanjut.create') }}" class="btn btn-primary mb-3">Tambah Tindak Lanjut</a> --}}
    <div class="card">
        <div class="card-body">
            <table id="zero_config" class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
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
                        {{-- <td>{{ $t->id_tindak }}</td> --}}
                        <td>{{ $t->pengaduan->judul }}</td>
                        <td class="d-flex align-items-center" style="gap: 10px">
                            @if ($t->petugas->foto)
                                <img src="{{ asset('storage/img-user/' . $t->petugas->foto) }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                            @else
                                <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                            @endif
                            <span>{{ $t->petugas->nama }}</span>
                        </td>
                        {{-- <td>{{ $t->petugas->nama ?? '-' }}</td> --}}
                        <td>{{ $t->tanggal_tindak }}</td>
                        <td>
                            <span class="badge {{ $t->status_akhir == 'selesai' ? 'badge-success' : 'badge-warning' }}">
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
                            <a href="{{ route('backend.petugas.detailaduan', $t->pengaduan->id_pengaduan) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-chat-right-text-fill"></i> Chat
                            </a>
                            <form action="{{ route('backend.petugas.tindaklanjut.destroy', $t->id_tindak) }}" method="POST" class="form-hapus-tindaklanjut" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-hapus-tindaklanjut"><i class="bi bi-trash3-fill"></i> Hapus</button>
                            </form>
                            <a href="{{ route('backend.petugas.detail_tindaklanjut', $t->id_tindak) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i> Detail</a>
                        </td>
                    </tr>
                    @endforeach
                    @if($tindaklanjut->isEmpty())
                        <tr><td colspan="7" class="text-center">Belum ada data.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


@section('script')
<script>
    // Konfirmasi hapus tindak lanjut dengan SweetAlert2
    document.querySelectorAll('.btn-hapus-tindaklanjut').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let form = this.closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus',
                text: "Tindak lanjut yang dihapus tidak dapat dikembalikan!, lalu status pengaduan ini akan berubah menjadi diterima, jika anda ingin menindak lanjuti lagi atau menyerahkan pengaduan ke petugas lain!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
@endsection
