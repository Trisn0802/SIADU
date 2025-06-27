@extends('backend.v_layouts.app')

@section('content')
<style>
    .auto-mb-card { border-radius: 8px; margin-bottom: 0.5rem; }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
                <h1 class="card-title text-center">{{ $judul }}</h1>
                <hr>
                <div class="row g-3 mt-3">
                    @forelse($tindaklanjut as $item)
                    <div class="col-lg-4 col-sm-6 col-md-12 auto-mb-card">
                        <div class="card h-100 border" style="border-radius: 8px">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title mb-0" style="font-size: 1.2rem;">
                                        <i>{{ $item->pengaduan->judul }}</i>
                                    </h3>
                                    <span class="badge
                                        @if($item->status_akhir == 'selesai') badge-success
                                        @else badge-warning @endif"
                                        style="border-radius: 8px;">
                                        {{ ucfirst($item->status_akhir) }}
                                    </span>
                                </div>
                                <hr>
                                <span class="badge badge-primary" style="border-radius: 8px; float: right;">
                                    {{ $item->tanggal_tindak }}
                                </span>
                                <p class="card-text mb-1">
                                    <b>Ditangani oleh:</b>
                                    {{ $item->petugas->nama ?? '-' }}
                                </p>
                                <p class="card-text">
                                    <b>Catatan:</b>
                                    {{ \Illuminate\Support\Str::limit($item->catatan, 80, '...') }}
                                </p>
                                <div class="mt-3">
                                    <a href="{{ route('backend.user.detail_tindaklanjut', $item->id_tindak) }}" class="btn btn-info btn-sm">
                                        Detail Tindak Lanjut
                                    </a>
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
                                <span class="text-muted" style="font-size: 1.2rem;">Belum ada riwayat tindak lanjut.</span>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
