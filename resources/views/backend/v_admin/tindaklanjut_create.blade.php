@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <h3>{{$judul}}</h3>
    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <form action="{{ route('backend.tindaklanjut.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Foto (opsional)</label>
                                <img src="{{ asset('storage/img-pengaduan/img-pengaduan-default.png') }}" class="foto-preview" width="100%" style="border-radius: 5px; border: 1px solid gray;">
                                <img class="foto-preview-new img-fluid mb-3" style="display: none;" width="100%">
                                <p></p>
                                <input type="file" name="foto" accept="image/*" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                @error('foto')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6 col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="id_pengaduan" value="{{ $pengaduan->id_pengaduan }}">
                                <div class="form-group">
                                    <label>Judul Pengaduan</label>
                                    <input type="text" class="form-control" value="{{ $pengaduan->judul }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama Pengadu</label>
                                <input type="text" class="form-control" value="{{ $pengaduan->user->nama ?? '-' }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Tindak</label>
                                <input type="datetime-local" name="tanggal_tindak" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status Akhir</label>
                                <select name="status_akhir" class="form-control" required>
                                    <option value="diproses">Diproses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('backend.tindaklanjut.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
