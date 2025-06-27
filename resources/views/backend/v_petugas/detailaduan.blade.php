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
                    <br>
                    @if($aduan->status == 'belum ditangani')
                        <form action="{{ route('backend.petugas.aduan.aksi', $aduan->id_pengaduan) }}" method="POST" class="form-aksi-pengaduan" style="display:inline;">
                            @csrf
                            <input type="hidden" name="aksi" value="terima">
                            <button type="button" class="btn btn-success mt-2 btn-terima">
                                <i class="fas fa-check"></i> Terima Pengaduan
                            </button>
                        </form>
                        <form action="{{ route('backend.petugas.aduan.aksi', $aduan->id_pengaduan) }}" method="POST" class="form-aksi-pengaduan" style="display:inline;">
                            @csrf
                            <input type="hidden" name="aksi" value="tolak">
                            <button type="button" class="btn btn-danger mt-2 btn-tolak">
                                <i class="fas fa-times"></i> Tolak Pengaduan
                            </button>
                        </form>
                    @endif
                    @if(in_array($aduan->status, ['diterima', 'diproses']))
                        <a href="{{ route('backend.petugas.tindaklanjut.create', ['id_pengaduan' => $aduan->id_pengaduan]) }}" class="btn btn-warning mt-2">
                            <i class="fas fa-plus-circle"></i> Tindak Lanjut
                        </a>
                    @endif
                    {{-- Tombol Info Tindak Lanjut Terakhir --}}
                    @if($lastTindak)
                        <a href="{{ route('backend.petugas.detail_tindaklanjut', $lastTindak->id_tindak) }}" class="btn btn-info mt-2">
                            <i class="fas fa-info-circle"></i> Info Tindak Lanjut Terakhir
                        </a>
                    @endif
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

                {{-- Form chat khusus petugas --}}
                <div class="card-body border-top">
                    @include('backend.v_petugas._form_chat_petugas', ['aduan' => $aduan])
                </div>
            </div>
            <!-- End Card Chat -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi Terima
    document.querySelectorAll('.btn-terima').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let form = this.closest('form');
            Swal.fire({
                title: 'Terima Pengaduan',
                text: "Pengaduan akan diterima dan diproses lalu di tindak lanjuti, apakah anda yakin?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Konfirmasi Tolak
    document.querySelectorAll('.btn-tolak').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let form = this.closest('form');
            Swal.fire({
                title: 'Tolak Pengaduan',
                text: "Pengaduan akan ditolak dan tidak diproses!, mohon berikan alasan tolak dulu di chat sebelum menolak aduan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

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
            btnKirim.classList.remove('btn-secondary');
            btnKirim.classList.add('btn-cyan');
            btnKirim.disabled = false;
        });
    });
</script>

<script>
    // Auto-scroll ke bawah saat halaman pertama kali dibuka
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const chatBox = document.querySelector('.chat-box');
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }, 180);
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
