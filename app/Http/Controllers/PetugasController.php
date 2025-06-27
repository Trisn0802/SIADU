<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Events\PengaduanStatusUpdated;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Chat;
use App\Models\TindakLanjut;
use Illuminate\Support\Facades\Hash;
use App\Models\Notifikasi;
use App\Events\UserNotification;
use App\Mail\NotifikasiUserMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PetugasController extends Controller
{
    public function index() {
        // Dashboard data khusus petugas
        $aduanBaru = Pengaduan::where('status', 'belum ditangani')->count();
        $aduanDitolakHariIni = Pengaduan::where('status', 'ditolak')->whereDate('created_at', now())->count();
        $aduanDiprosesHariIni = Pengaduan::where('status', 'diproses')->whereDate('created_at', now())->count();
        $aduanHariIni = Pengaduan::whereDate('created_at', now())->count();
        $aduanBulanIni = Pengaduan::whereMonth('created_at', now()->month)->count();

        // Chart bar: status hari ini
        $barData = Pengaduan::selectRaw('status, count(*) as total')
            ->whereDate('created_at', now())
            ->groupBy('status')
            ->pluck('total', 'status');

        // Chart pie: status bulan ini
        $pieData = Pengaduan::selectRaw('status, count(*) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('status')
            ->pluck('total', 'status');

        // Chart kategori: kategori bulan ini
        $kategoriData = Pengaduan::selectRaw('kategori, count(*) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return view('backend.v_petugas.index', compact(
            'aduanBaru', 'aduanDitolakHariIni', 'aduanDiprosesHariIni',
            'aduanHariIni', 'aduanBulanIni',
            'barData', 'pieData', 'kategoriData'
        ));
    }

    public function dashboardData()
    {
        $aduanBaru = Pengaduan::where('status', 'belum ditangani')->count();
        $aduanDitolakHariIni = Pengaduan::where('status', 'ditolak')->whereDate('created_at', now())->count();
        $aduanDiprosesHariIni = Pengaduan::where('status', 'diproses')->whereDate('created_at', now())->count();
        $aduanHariIni = Pengaduan::whereDate('created_at', now())->count();
        $aduanBulanIni = Pengaduan::whereMonth('created_at', now()->month)->count();

        $barData = Pengaduan::selectRaw('status, count(*) as total')
            ->whereDate('created_at', now())
            ->groupBy('status')
            ->pluck('total', 'status');

        $pieData = Pengaduan::selectRaw('status, count(*) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('status')
            ->pluck('total', 'status');

        $kategoriData = Pengaduan::selectRaw('kategori, count(*) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        return response()->json([
            'aduanBaru' => $aduanBaru,
            'aduanDitolakHariIni' => $aduanDitolakHariIni,
            'aduanDiprosesHariIni' => $aduanDiprosesHariIni,
            'aduanHariIni' => $aduanHariIni,
            'aduanBulanIni' => $aduanBulanIni,
            'barData' => $barData,
            'pieData' => $pieData,
            'kategoriData' => $kategoriData,
        ]);
    }

    public function edit()
    {
        $edit = auth()->user();
        return view('backend.v_petugas.edit', [
            'judul' => 'Edit Profil Petugas',
            'edit' => $edit
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'nama' => 'required|max:255',
            'nik' => 'nullable|max:16',
            'no_hp' => 'required|min:10|max:13',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
            'email' => 'required|max:255|email|unique:user,email,' . $user->id_user . ',id_user',
        ];

        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ];

        $validatedData = $request->validate($rules, $messages);

        if ($request->file('foto')) {
            // Delete old image
            if ($user->foto) {
                $oldImagePath = public_path('storage/img-user/') . $user->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-user/';

            // Save image with specified dimensions
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);
            $validatedData['foto'] = $originalFileName;
        }

        $user->update($validatedData);

        return redirect()->back()->with('success', 'Data berhasil diperbaharui');
    }

    public function gantiPassword()
    {
        $edit = auth()->user();
        return view('backend.v_petugas.gantipassword', [
            'judul' => 'Ganti Password',
            'edit' => $edit
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:4|confirmed',
        ]);
        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->withErrors(['password_lama' => 'Password lama salah.']);
        }
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';
        if (!preg_match($pattern, $request['password_baru'])) {
            return redirect()->back()->withErrors([
                'password_baru' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol karakter.'
            ]);
        }
        if (Hash::check($request->password_baru, $user->password)) {
            return redirect()->back()->withErrors(['password_baru' => 'Password baru tidak boleh sama dengan password lama.']);
        }
        $user->password = Hash::make($request->password_baru);

        $user->save();

        return redirect()->route('backend.petugas.dashboard')->with('success', 'Password berhasil diubah.');
    }

    public function pengaduanList() {
        $pengaduan = Pengaduan::with('user')->orderByDesc('created_at')->get();
        return view('backend.v_petugas.pengaduan', [
            'judul' => 'Data Pengaduan',
            'pengaduan' => $pengaduan,
        ]);
    }

    public function detailAduan($id_pengaduan) {
        $aduan = Pengaduan::with('user')->find($id_pengaduan);
        if (!$aduan) {
            return redirect()->route('backend.petugas.pengaduan')
                ->with('error', 'Pengaduan tidak ditemukan.');
        }
        $chats = Chat::where('id_pengaduan', $id_pengaduan)->orderBy('created_at')->get();
        // Ambil tindak lanjut terakhir
        $lastTindak = TindakLanjut::where('id_pengaduan', $aduan->id_pengaduan)
            ->orderByDesc('id_tindak')->first();
        return view('backend.v_petugas.detailaduan', compact('aduan', 'chats', 'lastTindak'));
    }

    public function aksiPengaduan(Request $request, $id_pengaduan)
    {
        $aduan = Pengaduan::findOrFail($id_pengaduan);

        if ($aduan->status != 'belum ditangani') {
            return back()->with('error', 'Pengaduan sudah diproses.');
        }

        $judulAduan = $aduan->judul;
        $user = $aduan->user;

        if ($request->aksi == 'terima') {
            $aduan->status = 'diterima';
            $aduan->save();

            // Kirim chat otomatis
            $chat = Chat::create([
                'id_pengaduan' => $aduan->id_pengaduan,
                'id_user' => auth()->user()->id_user,
                'pesan' => 'Pengaduan "' . $judulAduan . '" telah diterima dan akan segera diproses oleh petugas.',
            ]);
            $chat->load('user');

            broadcast(new ChatSent($chat))->toOthers();
            event(new PengaduanStatusUpdated($aduan->id_pengaduan, $aduan->status));
            event(new \App\Events\PengaduanUpdated());

            // Notifikasi untuk user pelapor
            $notif = Notifikasi::create([
                'id_user' => $user->id_user,
                'id_pengaduan' => $aduan->id_pengaduan,
                'type' => 'status',
                'title' => 'Pengaduan Diterima',
                'pesan' => 'Pengaduan "' . $judulAduan . '" Anda telah diterima oleh petugas. Klik untuk melihat detail.',
                'url' => route('backend.user.detailaduan', $aduan->id_pengaduan),
                'is_read' => 0,
            ]);

            event(new UserNotification(
                $user->id_user,
                'Pengaduan Diterima',
                'Pengaduan "' . $judulAduan . '" Anda telah diterima oleh petugas. Klik untuk melihat detail.',
                route('backend.user.detailaduan', $aduan->id_pengaduan),
                $notif->id_notifikasi
            ));

            // === Kirim Email ===
            $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
            $judul = 'Status Pengaduan Diperbarui';
            $pesan = 'Status pengaduan "' . $aduan->judul . '" Anda telah diperbarui menjadi: ' . ucfirst($aduan->status) . '.';
            $penanggap = auth()->user()->nama;
            $tanggal = Carbon::now()->format('Y-m-d H:i:s');
            $judulPengaduan = $aduan->judul;
            $url = route('backend.user.detailaduan', $aduan->id_pengaduan);
            Mail::to($user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

            return back()->with('success', 'Pengaduan berhasil diterima.');
        }

        if ($request->aksi == 'tolak') {
            $aduan->status = 'ditolak';
            $aduan->save();

            // Kirim chat otomatis
            $chat = Chat::create([
                'id_pengaduan' => $aduan->id_pengaduan,
                'id_user' => auth()->user()->id_user,
                'pesan' => 'Maaf, pengaduan "' . $judulAduan . '" anda ditolak. Silakan cek riwayat percakapan aduan.',
            ]);
            $chat->load('user');

            broadcast(new ChatSent($chat))->toOthers();
            event(new PengaduanStatusUpdated($aduan->id_pengaduan, $aduan->status));
            event(new \App\Events\PengaduanUpdated());

            // Notifikasi untuk user pelapor
            $notif = Notifikasi::create([
                'id_user' => $user->id_user,
                'id_pengaduan' => $aduan->id_pengaduan,
                'type' => 'status',
                'title' => 'Pengaduan Ditolak',
                'pesan' => 'Maaf, pengaduan "' . $judulAduan . '" Anda ditolak. Silakan cek riwayat percakapan aduan.',
                'url' => route('backend.user.detailaduan', $aduan->id_pengaduan),
                'is_read' => 0,
            ]);

            event(new UserNotification(
                $user->id_user,
                'Pengaduan Ditolak',
                'Maaf, pengaduan "' . $judulAduan . '" Anda ditolak. Silakan cek riwayat percakapan aduan.',
                route('backend.user.detailaduan', $aduan->id_pengaduan),
                $notif->id_notifikasi
            ));

            // === Kirim Email ===
            $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
            $judul = 'Status Pengaduan Diperbarui';
            $pesan = 'Status pengaduan "' . $aduan->judul . '" Anda telah diperbarui menjadi: ' . ucfirst($aduan->status) . '.';
            $penanggap = auth()->user()->nama;
            $tanggal = Carbon::now()->format('Y-m-d H:i:s');
            $judulPengaduan = $aduan->judul;
            $url = route('backend.user.detailaduan', $aduan->id_pengaduan);
            Mail::to($user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

            return back()->with('success', 'Pengaduan berhasil ditolak.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }

    public function sendChat(Request $request, $id_pengaduan) {
        $request->validate([
            'pesan' => 'required|string',
        ]);

        $pengaduan = Pengaduan::with('user')->findOrFail($id_pengaduan);

        $chat = Chat::create([
            'id_pengaduan' => $id_pengaduan,
            'id_user' => auth()->user()->id_user,
            'pesan' => $request->pesan,
        ]);
        $chat->load('user');
        broadcast(new ChatSent($chat))->toOthers();

        $user = $pengaduan->user;
        $judulAduan = $pengaduan->judul;

        $notifPesan = 'Anda menerima pesan baru dari petugas di Pengaduan "' . $judulAduan . '". Klik untuk melihat detail.';

        $notif = Notifikasi::create([
            'id_user' => $user->id_user,
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'type' => 'chat',
            'title' => 'Pesan Baru dari Petugas',
            'pesan' => $notifPesan,
            'url' => route('backend.user.detailaduan', $pengaduan->id_pengaduan),
            'is_read' => 0,
        ]);

        event(new UserNotification(
            $user->id_user,
            'Pesan Baru dari Petugas',
            $notifPesan,
            route('backend.user.detailaduan', $pengaduan->id_pengaduan),
            $notif->id_notifikasi
        ));

        // === Kirim Email ===
        $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
        $judul = 'Pengaduan Anda ditanggapi ' . auth()->user()->nama;
        $pesan = $request->pesan;
        $penanggap = auth()->user()->nama;
        $tanggal = Carbon::now()->format('Y-m-d H:i:s');
        $judulPengaduan = $pengaduan->judul;
        $url = route('backend.user.detailaduan', $pengaduan->id_pengaduan);
        Mail::to($user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

        return back();
    }

    public function getNotifikasi()
    {
        $notifikasi = Notifikasi::where('id_user', auth()->user()->id_user)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        return response()->json($notifikasi);
    }

    public function countNotifikasiUnread()
    {
        $count = Notifikasi::where('id_user', auth()->user()->id_user)
            ->where('is_read', 0)
            ->count();
        return response()->json(['count' => $count]);
    }

    public function readAllNotifikasi()
    {
        Notifikasi::where('id_user', auth()->user()->id_user)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        return response()->json(['success' => true]);
    }

    public function deleteNotifikasi($id)
    {
        Notifikasi::where('id_notifikasi', $id)
            ->where('id_user', auth()->user()->id_user)
            ->delete();
        return response()->json(['success' => true]);
    }

    public function deleteAllNotifikasi()
    {
        Notifikasi::where('id_user', auth()->user()->id_user)->delete();
        return response()->json(['success' => true]);
    }

    public function tindaklanjutIndex() {
        $tindaklanjut = TindakLanjut::with(['pengaduan', 'petugas'])
            ->where('id_user', auth()->user()->id_user)
            ->orderByDesc('created_at')
            ->get();
        return view('backend.v_petugas.tindaklanjut_index', [
            'judul'=> 'Tindak Lanjut Saya',
            'tindaklanjut'=> $tindaklanjut
        ]);
    }

    public function tindaklanjutCreate($id_pengaduan) {
        $pengaduan = Pengaduan::find($id_pengaduan);
        if (!$pengaduan) {
            return redirect()->route('backend.petugas.tindaklanjut')
                ->with('error', 'Pengaduan tidak ditemukan atau sudah dihapus.');
        }
        if (!in_array($pengaduan->status, ['diterima', 'diproses'])) {
            return back()->with('error', 'Tindak lanjut hanya bisa dilakukan jika status pengaduan diterima atau diproses.');
        }
        return view('backend.v_petugas.tindaklanjut_create', [
            'judul'=> 'Tindak Lanjut',
            'pengaduan'=> $pengaduan
        ]);
    }

    public function tindaklanjutStore(Request $request) {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduan,id_pengaduan',
            'tanggal_tindak' => 'required|date',
            'catatan' => 'required',
            'status_akhir' => 'required|in:diproses,selesai',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        $pengaduan = Pengaduan::find($request->id_pengaduan);
        if (!$pengaduan) {
            return redirect()->route('backend.petugas.tindaklanjut')
                ->with('error', 'Pengaduan tidak ditemukan atau sudah dihapus.');
        }
        if (!in_array($pengaduan->status, ['diterima', 'diproses'])) {
            return back()->with('error', 'Tindak lanjut hanya bisa dilakukan jika status pengaduan diterima atau diproses.');
        }
        $data = $request->only(['id_pengaduan', 'tanggal_tindak', 'catatan', 'status_akhir']);
        $data['id_user'] = auth()->user()->id_user;

        // Handle image upload only if all inputs are valid
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-tindaklanjut/';

            // Save image with specified dimensions
            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $data['foto'] = $originalFileName;
        }

        // Chat otomatis
        $statusPesan = [
            'diproses' => 'Aduan anda sedang diproses oleh petugas, silahkan cek di menu riwayat tindak lanjut',
            'selesai' => 'Aduan anda telah selesai ditangani. silahkan cek di menu riwayat tindak lanjut',
        ];
        $pesan = $statusPesan[$request->status_akhir] ?? 'Status aduan diperbarui.';

        $chat = Chat::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'id_user' => auth()->user()->id_user,
            'pesan' => $pesan,
        ]);
        $chat->load('user');
        broadcast(new ChatSent($chat))->toOthers();

        // Status pengaduan update
        if ($pengaduan->status == 'diterima') {
            $pengaduan->status = 'diproses';
            $pengaduan->save();
            event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
            event(new \App\Events\PengaduanUpdated());
        }
        if ($request->status_akhir == 'selesai') {
            $pengaduan->status = 'selesai';
            $pengaduan->save();
            event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
            event(new \App\Events\PengaduanUpdated());
        }

        // Simpan data tindak lanjut
        $tindaklanjut = TindakLanjut::create($data);

        $user = $pengaduan->user;
        $judulAduan = $pengaduan->judul;

        $notifPesan = 'Pengaduan "' . $judulAduan . '" Anda telah ditindaklanjuti. Klik untuk melihat detail.';

        $notif = Notifikasi::create([
            'id_user' => $user->id_user,
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'type' => 'tindaklanjut',
            'title' => 'Tindak Lanjut Baru',
            'pesan' => $notifPesan,
            'url' => route('backend.user.detail_tindaklanjut', $tindaklanjut->id_tindak),
            'is_read' => 0,
        ]);

        event(new UserNotification(
            $user->id_user,
            'Tindak Lanjut Baru',
            $notifPesan,
            route('backend.user.detail_tindaklanjut', $tindaklanjut->id_tindak),
            $notif->id_notifikasi
        ));

        // === Kirim Email ===
        $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
        $judul = 'Pengaduan Anda ditanggapi ' . auth()->user()->nama;
        $pesan = $request->catatan;
        $penanggap = auth()->user()->nama;
        $tanggal = Carbon::now()->format('Y-m-d H:i:s');
        $judulPengaduan = $pengaduan->judul;
        $url = route('backend.user.detail_tindaklanjut', $tindaklanjut->id_tindak);
        Mail::to($pengaduan->user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

        return redirect()->route('backend.petugas.tindaklanjut')->with('success', 'Tindak lanjut berhasil disimpan');
    }

    public function destroyTindakLanjut($id_tindak)
    {
        $tindak = TindakLanjut::findOrFail($id_tindak);
        // Pastikan hanya milik sendiri
        if ($tindak->id_user != auth()->user()->id_user) {
            abort(403, 'Akses tidak diizinkan');
        }
        $id_pengaduan = $tindak->id_pengaduan;

        // Hapus file foto jika ada
        if ($tindak->foto) {
            $fotoPath = public_path('storage/img-tindaklanjut/') . $tindak->foto;
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        $tindak->delete();

        // Cek apakah ini tindak lanjut terakhir
        $lastTindak = TindakLanjut::where('id_pengaduan', $id_pengaduan)
            ->orderByDesc('id_tindak')->first();

        $pengaduan = Pengaduan::find($id_pengaduan);

        if (!$lastTindak && $pengaduan) {
            // Jika sudah tidak ada tindak lanjut, kembalikan status ke 'diterima'
            $pengaduan->status = 'diterima';
            $pengaduan->save();

            // Kirim chat otomatis ke user
            $chat = Chat::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_user' => auth()->user()->id_user,
                'pesan' => 'Tindak lanjut terakhir dihapus. Pengaduan anda kembali ke status diterima dan akan segera diproses ulang oleh petugas.',
            ]);
            $chat->load('user');
            broadcast(new ChatSent($chat))->toOthers();

            // Broadcast status pengaduan
            event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
            event(new \App\Events\PengaduanUpdated());

            $user = $pengaduan->user;

            $notif = Notifikasi::create([
                'id_user' => $user->id_user,
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'type' => 'tindaklanjut',
                'title' => 'Tindak Lanjut Dihapus',
                'pesan' => 'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin.',
                'url' => route('backend.user.detailaduan', $pengaduan->id_pengaduan),
                'is_read' => 0,
            ]);

            event(new UserNotification(
                $user->id_user,
                'Tindak Lanjut Dihapus',
                'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin.',
                route('backend.user.detailaduan', $pengaduan->id_pengaduan),
                $notif->id_notifikasi
            ));

            // === Kirim Email ===
            $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
            $judul = 'Tindak Lanjut Dihapus';
            $pesan = 'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin. Status pengaduan Anda kembali ke "Diterima".';
            $penanggap = auth()->user()->nama;
            $tanggal = Carbon::now()->format('Y-m-d H:i:s');
            $judulPengaduan = $pengaduan->judul;
            $url = route('backend.user.detailaduan', $pengaduan->id_pengaduan);
            Mail::to($user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

        } elseif ($lastTindak && $pengaduan) {
            // Jika masih ada tindak lanjut, update status pengaduan sesuai status_akhir tindak lanjut terakhir
            $pengaduan->status = $lastTindak->status_akhir == 'selesai' ? 'selesai' : 'diproses';
            $pengaduan->save();

            // Kirim chat otomatis ke user
            $pesanChat = $lastTindak->status_akhir == 'selesai'
                ? 'Tindak lanjut terakhir dihapus. Status pengaduan anda kini selesai.'
                : 'Tindak lanjut terakhir dihapus. Status pengaduan anda kini diproses.';
            $chat = Chat::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_user' => auth()->user()->id_user,
                'pesan' => $pesanChat,
            ]);
            $chat->load('user');
            broadcast(new ChatSent($chat))->toOthers();

            event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
            event(new \App\Events\PengaduanUpdated());

            // Buat Notifikasi
            $notif = Notifikasi::create([
                'id_user' => $pengaduan->user->id_user,
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'type' => 'tindaklanjut',
                'title' => 'Tindak Lanjut Dihapus',
                'pesan' => 'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin.',
                'url' => route('backend.user.detailaduan', $pengaduan->id_pengaduan),
                'is_read' => 0,
            ]);
            event(new UserNotification(
                $pengaduan->user->id_user,
                'Tindak Lanjut Dihapus',
                'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin.',
                route('backend.user.detailaduan', $pengaduan->id_pengaduan),
                $notif->id_notifikasi
            ));

            // === Kirim Email ===
            $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
            $judul = 'Tindak Lanjut Dihapus';
            $pesan = 'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin. Status pengaduan Anda kini "' . ucfirst($pengaduan->status) . '".';
            $penanggap = auth()->user()->nama;
            $tanggal = Carbon::now()->format('Y-m-d H:i:s');
            $judulPengaduan = $pengaduan->judul;
            // Email diarahkan ke detail pengaduan, bukan ke detail tindak lanjut yang sudah dihapus
            $url = route('backend.user.detailaduan', $pengaduan->id_pengaduan);
            Mail::to($pengaduan->user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));
        }

        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus.');
    }

    public function detailTindakLanjut($id_tindak) {
        $tindak = TindakLanjut::with(['pengaduan.user', 'petugas'])->find($id_tindak);
        if (!$tindak) {
            return redirect()->route('backend.petugas.tindaklanjut')
                ->with('error', 'Tindak lanjut tidak ditemukan atau dihapus.');
        }
        // Pastikan hanya milik sendiri
        if ($tindak->id_user != auth()->user()->id_user) {
            abort(403, 'Akses tidak diizinkan');
        }
        return view('backend.v_petugas.detail_tindaklanjut', compact('tindak'));
    }

}
