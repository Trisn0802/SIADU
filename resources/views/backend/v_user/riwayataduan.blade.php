@extends('backend.v_layouts.app')

@section('content')
    <style>
        .auto-mb-card {
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
    </style>
    <!-- contentAwal -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body border-top">
                    <h1 class="card-title text-center">{{ $judul }}</h1>
                    <hr>
                    <div class="row g-3 mt-3">
                        @forelse($aduan as $item)
                        <div class="col-lg-4 col-sm-6 col-md-12 auto-mb-card">
                            <div class="card h-100 border" style="border-radius: 8px">
                                {{-- {{dd($item->foto)}} --}}
                                {{-- @if ($item->foto)
                                    <img src="{{ asset('storage/img-pengaduan/' . $item->foto) }}" class="card-img-top" alt="Foto Aduan" width="100%" style="border-radius: 8px;">
                                @else
                                    <img src="{{ asset('storage/img-pengaduan/img-default.jpg') }}" class="card-img-top" alt="Foto Aduan" width="100%" style="border-radius: 8px;">
                                @endif --}}
                                {{-- <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://cdn.rri.co.id/berita/102/images/1700718118899-I/bots2x9uz4vuoz7.jpeg' }}" class="card-img-top" alt="Foto Aduan"> --}}
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title mb-0" style="font-size: 1.2rem;">
                                            <i>{{ $item->judul }}</i>
                                        </h3>
                                        <span class="badge
                                            @if($item->status == 'belum ditangani') badge-dark
                                            @elseif($item->status == 'diterima') badge-info
                                            @elseif($item->status == 'diproses') badge-warning
                                            @elseif($item->status == 'ditolak') badge-danger
                                            @elseif($item->status == 'selesai') badge-success
                                            @else badge-secondary @endif"
                                            style="border-radius: 8px;">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <hr>
                                    <span class="badge badge-primary" style="border-radius: 8px; float: right;">
                                        {{ $item->tanggal_lapor }}
                                    </span>
                                    <p class="card-text mb-1" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $item->deskripsi }}
                                    </p>
                                    <p class="card-text">
                                        <i class="mdi mdi-google-maps" style="font-size: 20px"></i>
                                        {{ $item->lokasi }}
                                    </p>
                                    {{-- <div class="mt-3">
                                        <a href="{{ route('backend.user.detailaduan', $item->id_pengaduan) }}" class="btn btn-secondary">Lihat selengkapnya <i class="bi bi-arrow-right"></i></a>
                                    </div> --}}
                                    <div class="mt-3 d-flex justify-content-between">
                                        <a href="{{ route('backend.user.detailaduan', $item->id_pengaduan) }}" class="btn btn-secondary">
                                            Lihat selengkapnya <i class="bi bi-arrow-right"></i>
                                        </a>
                                        <form action="{{ route('backend.user.aduan.destroy', $item->id_pengaduan) }}" method="POST" class="d-inline form-hapus-aduan">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm p-1 btn-hapus-aduan" data-judul="{{ $item->judul }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 62vh; position: relative;">
                                <div class="flex-grow-1 d-flex justify-content-center align-items-center w-100">
                                    <i class="bi bi-clock-fill" style="font-size: 80px"></i>
                                </div>
                                <div class="w-100 text-center" style="position: absolute; bottom: 0; left: 0;">
                                    <span class="text-muted" style="font-size: 1.2rem;">Belum ada riwayat aduan.</span>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
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
    <!-- contentAkhir -->
@endsection
