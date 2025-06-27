@extends('backend.v_layouts.app')

@section('content')
<!-- contentAwal -->
<div class="row">
    <div class="col-12">
        <a href="{{ route('backend.user.create') }}">
            <button type="button" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $judul }}</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Instansi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                            @php
                                $log = $row->latestHotspotLog;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="d-flex align-items-center" style="gap: 10px">
                                    @if ($row->foto)
                                        <img src="{{ asset('storage/img-user/' . $row->foto) }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                                    @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="Foto" class="img-fluid rounded-circle" width="25">
                                    @endif
                                    <span>{{ $row->nama }}</span>
                                </td>
                                <td>{{ $row->email }}</td>
                                <td>
                                    @if ($row->role == '1')
                                        <span class="badge badge-success">Admin</span>
                                    @elseif ($row->role == '2')
                                        <span class="badge badge-warning">Petugas</span>
                                    @elseif ($row->role == '0')
                                        <span class="badge badge-primary">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status == 1)
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif ($row->status == 0)
                                        <span class="badge badge-primary">Tidak Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->instansi != null)
                                        <span class="badge badge-info">{{$row->instansi}}</span>
                                    @elseif ($row->instansi == null)
                                        <span class="badge badge-dark">Belum ada instansi</span>
                                    @else
                                        <span class="badge badge-danger">Unknown</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.admin.edit', $row->id_user) }}" title="Ubah Data">
                                        <button type="button" class="btn btn-cyan btn-sm">
                                            <i class="far fa-edit"></i> Ubah
                                        </button>
                                    </a>
                                    <form method="POST" action="{{ route('backend.user.destroy', $row->id_user) }}" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $row->nama }}" title="Hapus Data">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contentAkhir -->
@endsection
