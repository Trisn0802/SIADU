<form id="chat-form" action="{{ route('backend.petugas.sendchat', $aduan->id_pengaduan) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-9">
            <div class="input-field m-t-0 m-b-0">
                <textarea name="pesan" placeholder="Type and enter" class="form-control border-0" required></textarea>
            </div>
        </div>
        <div class="col-3">
            <button type="submit" id="btn-kirim" class="btn-circle btn-lg btn-cyan float-right text-white" style="border:none;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</form>
