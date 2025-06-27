@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">{{ $judul }}</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <table id="zero_config" class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>User</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal Lapor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengaduan as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->user->nama ?? '-' }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>
                            @if ($item->status == 'belum ditangani')
                                <span class="badge badge-dark">{{ $item->status }}</span>
                            @elseif ($item->status == 'diterima')
                                <span class="badge badge-info">{{ $item->status }}</span>
                            @elseif ($item->status == 'diproses')
                                <span class="badge badge-warning">{{ $item->status }}</span>
                            @elseif ($item->status == 'ditolak')
                                <span class="badge badge-danger">{{ $item->status }}</span>
                            @elseif ($item->status == 'selesai')
                                <span class="badge badge-success">{{ $item->status }}</span>
                            @else
                                <span class="badge badge-secondary">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td>{{ $item->tanggal_lapor }}</td>
                        <td>
                            <a href="{{ route('backend.admin.detailaduan', $item->id_pengaduan) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                            <form class="form-hapus-aduan d-inline" action="{{ route('backend.admin.pengaduan.destroy', $item->id_pengaduan) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm p-1 btn-hapus-aduan" data-judul="{{ $item->judul }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($pengaduan->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data pengaduan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-hapus-aduan').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        let form = btn.closest('form');
        let judul = btn.getAttribute('data-judul');
        Swal.fire({
            title: 'Yakin ingin menghapus aduan?',
            text: 'Aduan "' + judul + '" akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
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
