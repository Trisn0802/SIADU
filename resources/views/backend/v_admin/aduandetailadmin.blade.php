@extends('backend.v_layouts.app')

@section('content')
<style>
    .chat-bubble-div {
        display: inline-block;
        background: #f5f6fa;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 1rem;
        line-height: 1.4;
        min-width: 80px;
        max-width: 100%;
        word-break: break-word;
        white-space: pre-wrap;
        box-sizing: border-box;
    }
    .chat-box {
        height: 475px;
        max-height: 80vh;
        overflow-y: auto;
        overflow-x: hidden;
    }
    @media (max-width: 576px) {
        .chat-box {
            height: 300px;
            max-height: 60vh;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card mb-3">
                @if ($aduan->foto)
                    <img src="{{ asset('storage/img-pengaduan/' . $aduan->foto) }}" class="card-img-top" alt="Foto Aduan" width="100%">
                @else
                    <img src="{{ asset('storage/img-pengaduan/img-default.jpg') }}" class="card-img-top" alt="Foto Aduan" width="100%">
                @endif
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ $aduan->user && $aduan->user->foto ? asset('storage/img-user/' . $aduan->user->foto) : asset('storage/img-user/img-default.jpg') }}"
                            alt="Foto Pengadu"
                            class="rounded-circle"
                            style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #eee;">
                        <div class="ml-3">
                            <div style="font-weight: bold; font-size: 1.1rem;">
                                {{ $aduan->user->nama ?? '-' }}
                            </div>
                            <div style="color: #666; font-size: 0.85rem;">
                                @php
                                    $hp = $aduan->user->no_hp ?? '';
                                    $wa = preg_replace('/\D/', '', $hp);
                                    if (substr($wa, 0, 1) === '0') $wa = '62' . substr($wa, 1);
                                @endphp
                                @if($wa)
                                    <a href="https://wa.me/{{ $wa }}"
                                    class="btn btn-success wa-confirm"
                                    data-wa="https://wa.me/{{ $wa }}"
                                    style="text-decoration: none; padding: 5px; border-radius: 15px;">
                                        {{ $hp }}
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h3 class="card-title"><i>{{ $aduan->judul }}</i></h3>
                    <p class="card-text">{{ $aduan->deskripsi }}</p>
                    <p><b>Kategori:</b> {{ $aduan->kategori }}</p>
                    <p><b>Lokasi:</b> {{ $aduan->lokasi }}</p>
                    <span class="badge badge-primary">{{ $aduan->tanggal_lapor }}</span>
                    <span class="badge badge-status
                        @if($aduan->status == 'belum ditangani') badge-dark
                        @elseif($aduan->status == 'diterima') badge-info
                        @elseif($aduan->status == 'diproses') badge-warning
                        @elseif($aduan->status == 'ditolak') badge-danger
                        @elseif($aduan->status == 'selesai') badge-success
                        @else badge-secondary @endif">
                        {{ ucfirst($aduan->status) }}
                    </span>
                    {{-- Admin bisa ubah status langsung --}}
                    <form action="{{ route('backend.admin.pengaduan.status', $aduan->id_pengaduan) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <select name="status" class="form-control form-control-sm" style="max-width: 160px;">
                                {{-- <option value="baru" {{ $aduan->status == 'baru' ? 'selected' : '' }}>Baru</option> --}}
                                <option value="" {{ $aduan->status == 'belum ditangani' ? 'selected' : '' }}>Pilih status</option>
                                <option value="diterima" {{ $aduan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="diproses" {{ $aduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="ditolak" {{ $aduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="selesai" {{ $aduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm ml-2">Ubah Status</button>
                        </div>
                    </form>

                    <form id="form-hapus-aduan" action="{{ route('backend.admin.pengaduan.destroy', $aduan->id_pengaduan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger p-1 mt-2" id="btn-hapus-aduan" title="Hapus Pengaduan">
                            <i class="bi bi-trash"></i> Hapus Pengaduan
                        </button>
                    </form>
                        <br>

                    @php
                        $lastTindak = \App\Models\TindakLanjut::where('id_pengaduan', $aduan->id_pengaduan)
                            ->orderByDesc('id_tindak')->first();
                    @endphp
                    {{-- @if ()

                    @endif --}}


                    {{-- Tombol tindak lanjut, hanya untuk status tertentu --}}
                    @if (in_array($aduan->status, ['diterima', 'diproses', 'selesai', 'ditolak']))
                    <a href="{{ route('backend.tindaklanjut.create', ['id_pengaduan' => $aduan->id_pengaduan]) }}" class="btn btn-warning mt-2">
                        <i class="fas fa-plus-circle"></i> Tindak Lanjut
                    </a>
                    @endif

                    <a href="{{ route('backend.admin.pengaduan.cetak', $aduan->id_pengaduan) }}" target="_blank" class="btn btn-danger mt-2">
                        <i class="fas fa-file-pdf"></i> Export Aduan Ke PDF
                    </a>
                    @if($lastTindak)
                        <a href="{{ route('backend.admin.detail_tindaklanjut', $lastTindak->id_tindak) }}" class="btn btn-info mt-2">
                            <i class="fas fa-info-circle"></i> Info Tindak Lanjut Terakhir
                        </a>
                    @endif
                    {{-- <br> --}}
                    {{-- @can('delete', $aduan)
                        <form action="{{ route('backend.admin.pengaduan.destroy', $aduan->id_pengaduan) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus aduan: {{ $aduan->judul }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger p-1" title="Hapus Pengaduan">
                                <i class="bi bi-trash"></i> Hapus Pengaduan
                            </button>
                        </form>
                    @endcan --}}
                </div>
            </div>
        </div>

        <div class="col-md-6 mx-auto">
            <!-- Card Chat -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Chat</h4>
                    <div class="chat-box scrollable" style="height:475px;">
                        <ul class="chat-list">
                            @foreach($chats as $chat)
                                <li class="chat-item {{ $chat->id_user == auth()->user()->id_user ? 'odd' : '' }}">
                                    @if($chat->id_user != auth()->user()->id_user)
                                        <div class="chat-img">
                                            <img src="{{ $chat->user->foto ? asset('storage/img-user/'.$chat->user->foto) : asset('storage/img-user/img-default.jpg') }}" alt="user">
                                        </div>
                                    @endif
                                    <div class="chat-content">
                                        @if($chat->id_user != auth()->user()->id_user)
                                            <div class="d-flex align-items-center mb-1">
                                                <h6 class="font-medium mb-0">{{ $chat->user->nama }}</h6>
                                                <span class="badge
                                                    @if($chat->user->role == '1') badge-success
                                                    @elseif($chat->user->role == '2') badge-warning
                                                    @else badge-primary @endif
                                                    ml-2" style="font-size: 0.75rem;">
                                                    @if($chat->user->role == '1')
                                                        Admin
                                                    @elseif($chat->user->role == '2')
                                                        Petugas
                                                    @else
                                                        User
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="box bg-light-info">{!! $chat->pesan !!}</div>
                                        @else
                                            <div class="box bg-light-inverse">{{ $chat->pesan }}</div>
                                        @endif
                                    </div>
                                    <div class="chat-time">{{ $chat->created_at->format('H:i') }}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                @php
                    $isUser = auth()->user()->role == 0;
                    $canChat = $isUser || in_array($aduan->status, ['diterima', 'diproses', 'ditolak','selesai']);
                @endphp

                @if($canChat)
                <div class="card-body border-top">
                    <form id="chat-form" action="{{ route('backend.admin.sendchat', $aduan->id_pengaduan) }}" method="POST">
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
                </div>
                @else
                    @if($aduan->status == 'belum ditangani')
                        <div class="card-body border-top text-center text-info">
                            Mohon di ubah status aduan terlebih dahulu untuk dapat melakukan chat!
                        </div>
                    @endif
                @endif
            </div>
            <!-- End Card Chat -->
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.iife.js"></script>
<script>
    // Pastikan variabel id_pengaduan tersedia di JS
    const id_pengaduan = @json($aduan->id_pengaduan);

    window.Echo = new window.Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    Echo.channel('chat.' + {{ $aduan->id_pengaduan }})
    .listen('ChatSent', (e) => {
        const chatList = document.querySelector('.chat-list');
        const isMe = e.chat.id_user == {{ auth()->user()->id_user }};
        const chatItem = document.createElement('li');
        chatItem.className = 'chat-item' + (isMe ? ' odd' : '');

        let chatContent = '';
        let foto = (e.chat.user && e.chat.user.foto) ? '/storage/img-user/' + e.chat.user.foto : '/storage/img-user/img-default.jpg';
        if (!isMe) {
            chatContent += `<div class="chat-img">
                <img src="${foto}" alt="user" onerror="this.onerror=null;this.src='/storage/img-user/img-default.jpg';">
            </div>`;
        }
        chatContent += `<div class="chat-content">`;
        if (!isMe) {
            let role = '';
            if (e.chat.user) {
                if (e.chat.user.role == '1') role = '<span class="badge badge-success ml-2" style="font-size:0.75rem;">Admin</span>';
                else if (e.chat.user.role == '2') role = '<span class="badge badge-warning ml-2" style="font-size:0.75rem;">Petugas</span>';
                else role = '<span class="badge badge-primary ml-2" style="font-size:0.75rem;">User</span>';
            }
            chatContent += `<div class="d-flex align-items-center mb-1">
                <h6 class="font-medium mb-0">${e.chat.user ? e.chat.user.nama : 'User'}</h6>
                ${role}
            </div>
            <div class="box bg-light-info">${e.chat.pesan}</div>`;
        } else {
            chatContent += `<div class="box bg-light-inverse">${e.chat.pesan}</div>`;
        }
        let waktu = new Date(e.chat.created_at);
        let jam = waktu.getHours().toString().padStart(2, '0');
        let menit = waktu.getMinutes().toString().padStart(2, '0');
        let waktuStr = jam + ':' + menit;
        chatContent += `</div>
            <div class="chat-time">${waktuStr}</div>`;

        chatItem.innerHTML = chatContent;
        chatList.appendChild(chatItem);

        // Scroll ke bawah otomatis
        const chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;

        // Reset textarea jika pengirim adalah user ini
        if (isMe) {
            const chatForm = document.getElementById('chat-form');
            if (chatForm) {
                chatForm.querySelector('textarea[name="pesan"]').value = '';
                const btnKirim = document.getElementById('btn-kirim');
                if (btnKirim) {
                    btnKirim.classList.remove('btn-secondary');
                    btnKirim.classList.add('btn-cyan');
                    btnKirim.disabled = false;
                }
            }
        }
    });
</script>

<script>
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let btnKirim = document.getElementById('btn-kirim');
        // Ubah ke btn-secondary dan disable
        btnKirim.classList.remove('btn-cyan');
        btnKirim.classList.add('btn-secondary');
        btnKirim.disabled = true;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .catch(() => {
            // Jika gagal, enable lagi dan kembalikan ke btn-cyan
            btnKirim.classList.remove('btn-secondary');
            btnKirim.classList.add('btn-cyan');
            btnKirim.disabled = false;
        });
    });
</script>

<script>
    window.Echo.channel('pengaduan.status')
        .listen('PengaduanStatusUpdated', (e) => {
            // Cek apakah status yang diupdate adalah aduan ini
            if (e.id_pengaduan == {{ $aduan->id_pengaduan }}) {
                // Update badge status di halaman
                const badge = document.querySelector('.badge-status');
                if (badge) {
                    badge.textContent = e.status.charAt(0).toUpperCase() + e.status.slice(1);
                    // Update class badge sesuai status baru
                    badge.className = 'badge badge-status ' + getBadgeClass(e.status);
                }

                // Update tampilan chat/form sesuai status baru
                updateChatFormByStatus(e.status);
            }
        });

    function getBadgeClass(status) {
        switch(status) {
            case 'belum ditangani': return 'badge-dark';
            case 'diterima': return 'badge-info';
            case 'diproses': return 'badge-warning';
            case 'ditolak': return 'badge-danger';
            case 'selesai': return 'badge-success';
            default: return 'badge-secondary';
        }
    }

    // Fungsi untuk update form chat sesuai status
    function updateChatFormByStatus(status) {
        const chatFormContainer = document.querySelector('.card .border-top');
        if (!chatFormContainer) return;

        @if(auth()->user()->role == 1)
            // Admin selalu bisa chat, tidak perlu update form
            return;
        @endif

        if (['diterima', 'diproses'].includes(status)) {
            // Tampilkan form chat
            chatFormContainer.innerHTML = `{!! str_replace("\n", '', trim(preg_replace('/\s+/', ' ', view('backend.v_admin._form_chat_admin', ['aduan' => $aduan])->render()))) !!}`;
        } else if (status == 'belum ditangani') {
            chatFormContainer.innerHTML = `<div class="text-center text-info">
                Mohon di ubah status aduan terlebih dahulu untuk dapat melakukan chat!
            </div>`;
        }
        // else if (status == 'ditolak') {
        //     chatFormContainer.innerHTML = `<div class="card-body border-top text-center text-danger">
        //         Pengaduan anda ditolak.
        //     </div>`;
        // } else if (status == 'selesai') {
        //     chatFormContainer.innerHTML = `<div class="card-body border-top text-center text-success">
        //         Pengaduan anda telah selesai ditangani.
        //     </div>`;
        // }
    }
</script>

<script>
    // Auto-scroll ke bawah saat halaman pertama kali dibuka
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const chatBox = document.querySelector('.chat-box');
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }, 180); // 100ms, bisa dinaikkan jika masih offside di HP
    });
</script>

{{-- Konfirmasi Hapus aduan --}}
<script>
document.getElementById('btn-hapus-aduan').addEventListener('click', function(e) {
    Swal.fire({
        title: 'Yakin ingin menghapus aduan?',
        text: 'Aduan "{{ $aduan->judul }}" akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-hapus-aduan').submit();
        }
    });
});
</script>

{{-- Konfirmasi Ke WA User --}}
<script>
document.querySelectorAll('.wa-confirm').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('data-wa');
        const nomor = this.textContent.trim();
        Swal.fire({
            title: 'Menuju WhatsApp',
            text: 'Anda akan diarahkan ke WhatsApp (' + nomor + ') Lanjutkan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(url, '_blank');
            }
        });
    });
});
</script>
@endsection
