@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">SIADU — {{ $judul }}</h4>
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          <form action="{{ route('backend.announcement.update') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
              <label for="title">Judul</label>
              <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $announcement->title) }}" placeholder="Judul (opsional)">
              @error('title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label for="announcement-editor">Konten Pengumuman</label>
              <textarea name="content" id="announcement-editor" class="form-control">{{ old('content', $announcement->content) }}</textarea>
              @error('content')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_active">Tampilkan di halaman login</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
{{-- Summernote Initialization (Local) - Dijalankan setelah jQuery dimuat --}}
<script>
  $(document).ready(function() {
    $('#announcement-editor').summernote({
      height: 400,
      minHeight: 300,
      maxHeight: 600,
      focus: true,
      placeholder: 'Tulis pengumuman SIADU di sini...',
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'italic', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ],
      callbacks: {
        onImageUpload: function(files) {
          uploadImage(files[0]);
        }
      }
    });

    function uploadImage(file) {
      let data = new FormData();
      data.append('image', file);
      data.append('_token', '{{ csrf_token() }}');

      $.ajax({
        url: '{{ route("backend.announcement.upload-image") }}',
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.success) {
            $('#announcement-editor').summernote('insertImage', response.url);
          } else {
            alert('Gagal upload gambar: ' + response.message);
          }
        },
        error: function(xhr) {
          let errorMsg = 'Gagal upload gambar';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMsg = xhr.responseJSON.message;
          }
          alert(errorMsg);
        }
      });
    }
  });
</script>
@endsection
