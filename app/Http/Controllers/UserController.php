<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengaduan;
use App\Models\Chat;
use App\Models\TindakLanjut;
use App\Models\Notifikasi;
use App\Events\ChatSent;
use App\Events\UserNotification;

class UserController extends Controller
{
    // Halaman beranda untuk user backend
    public function berandaUserBackend()
    {
        $user = auth()->user();
        return view('backend.v_user.index', [
            'judul' => 'Dashboard',
            'user' => $user
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        return view('backend.v_user.index', [
            'judul' => 'Data User',
            'index' => $user
        ]);
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
        $userId = auth()->user()->id_user;
        $count = Notifikasi::where('id_user', $userId)->count();

        if ($count === 0) {
            return response()->json(['success' => false, 'message' => 'Tidak ada notifikasi untuk dihapus.'], 400);
        }

        Notifikasi::where('id_user', $userId)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_user)
    {
        $user = User::findOrFail($id_user);

        // if (auth()->user()->role == 0 && auth()->user()->id != $user->id) {
        //     return redirect()->route('backend.user.edit', ['id' => auth()->user()->id])
        //         ->with('error', 'Anda tidak memiliki izin untuk mengedit profil ini.');
        // }

        if (auth()->user()->role == 0 && auth()->user()->id_user != $user->id_user) {
            return redirect()->route('backend.user.error.404')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit profil ini.');
        }

        return view('backend.v_user.edit', [
            'judul' => 'Profile User',
            'edit' => $user
        ]);
    }

    public function update(Request $request, string $id_user)
    {
        $user = User::findOrFail($id_user);

        $rules = [
            'nama' => 'required|max:255',
            // 'role' => 'required',
            // 'status' => 'required',
            'no_hp' => 'required|min:10|max:13',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];

        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|max:255|email|unique:user';
        }

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

        // Redirect based on role
        if (auth()->user()->role == 0) { // Role 0 for user
            return redirect()->back()->with('success', 'Data berhasil diperbaharui');
        }

        return redirect()
            ->route('backend.user.edit')
            ->with('success', 'Data berhasil diperbaharui');
    }

    public function gantiPassword(string $id_user)
    {
        $user = User::findOrFail($id_user);

        // if (auth()->user()->role == 0 && auth()->user()->id != $user->id) {
        //     return redirect()->route('backend.user.edit', ['id' => auth()->user()->id])
        //         ->with('error', 'Anda tidak memiliki izin untuk mengedit profil ini.');
        // }

        if (auth()->user()->role == 0 && auth()->user()->id_user != $user->id_user) {
            return redirect()->route('backend.user.error.404')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit profil ini.');
        }

        return view('backend.v_user.gantipassword', [
            'judul' => 'Ganti Password',
            'edit' => $user
        ]);
    }

    public function updatePassword(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);

        // Validasi input
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:4|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 4 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek password lama
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

        // Update password
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('backend.beranda.user')->with('success', 'Password berhasil diubah.');
    }

    public function storeAduan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $data = $request->only(['judul', 'lokasi', 'deskripsi', 'kategori']);
        $data['id_user'] = auth()->user()->id_user;

        // Upload foto jika ada
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-pengaduan/';

            // Save image with specified dimensions
            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $data['foto'] = $originalFileName;
        }

        $pengaduanBaru = Pengaduan::create($data);

        // Broadcast event agar dashboard realtime
        event(new \App\Events\PengaduanUpdated());

        // URL detail pengaduan untuk petugas
        $urlPengaduanPetugas = route('backend.petugas.detailaduan', $pengaduanBaru->id_pengaduan);
        $urlPengaduanAdmin = route('backend.admin.detailaduan', $pengaduanBaru->id_pengaduan);

        // === Notifikasi hanya ke petugas (role 2) ===
        $petugas = User::where('role', '2')->get();
        foreach ($petugas as $p) {
            $notif = Notifikasi::create([
                'id_user' => $p->id_user,
                'type' => 'pengaduan',
                'title' => 'Pengaduan Baru',
                'pesan' => 'Ada pengaduan baru dari ' . auth()->user()->nama . '. Silakan cek dan proses.',
                'url' => $urlPengaduanPetugas,
                'is_read' => 0,
            ]);
            event(new UserNotification(
                $p->id_user,
                'Pengaduan Baru',
                'Ada pengaduan baru dari ' . auth()->user()->nama . '. Silakan cek dan proses.',
                $urlPengaduanPetugas,
                $notif->id_notifikasi
            ));
        }

        $admin = User::where('role', '1')->get();
        foreach ($admin as $p) {
            $notif = Notifikasi::create([
                'id_user' => $p->id_user,
                'type' => 'pengaduan',
                'title' => 'Pengaduan Baru',
                'pesan' => 'Ada pengaduan baru dari ' . auth()->user()->nama . '. Silakan cek dan proses.',
                'url' => $urlPengaduanAdmin,
                'is_read' => 0,
            ]);
            event(new UserNotification(
                $p->id_user,
                'Pengaduan Baru',
                'Ada pengaduan baru dari ' . auth()->user()->nama . '. Silakan cek dan proses.',
                $urlPengaduanAdmin,
                $notif->id_notifikasi
            ));
            // dd($admin);
        }

        return redirect()->route('backend.user.riwayataduan')->with('success', 'Aduan berhasil dikirim!');
    }

    public function riwayatAduan()
    {
        $user = auth()->user();
        $aduan = Pengaduan::where('id_user', $user->id_user)->orderByDesc('created_at')->get();
        return view('backend.v_user.riwayataduan', [
            'judul' => 'Riwayat Aduan',
            'aduan' => $aduan,
        ]);
    }

    public function detailAduan($id_pengaduan)
    {
        // Ambil aduan milik user yang sedang login
        $aduan = Pengaduan::where('id_pengaduan', $id_pengaduan)
            ->where('id_user', auth()->user()->id_user)
            ->first();

        if (!$aduan) {
            // Jika tidak ditemukan, redirect back dengan pesan error
            return redirect()->route('backend.user.riwayataduan')->with('error', 'Pengaduan tidak ditemukan!');
        }

        $lastTindak = TindakLanjut::where('id_pengaduan', $aduan->id_pengaduan)
            ->orderByDesc('id_tindak')->first();

        $chats = Chat::where('id_pengaduan', $id_pengaduan)->orderBy('created_at')->get();

        return view('backend.v_user.detailaduan', compact('aduan', 'chats', 'lastTindak'));
    }

    public function sendChat(Request $request, $id_pengaduan)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        $pengaduan = Pengaduan::findOrFail($id_pengaduan);

        // Pastikan user hanya bisa mengirim chat untuk aduannya sendiri
        if ($pengaduan->id_user != auth()->user()->id_user) {
            abort(403, 'Akses tidak diizinkan');
        }

        $chat = Chat::create([
            'id_pengaduan' => $id_pengaduan,
            'id_user' => auth()->user()->id_user,
            'pesan' => $request->pesan,
        ]);

        $chat->load('user');

        broadcast(new ChatSent($chat))->toOthers();

        // === Notifikasi ke semua petugas yang menangani pengaduan ini ===
        $nama_user = auth()->user()->nama;
        if (method_exists($pengaduan, 'petugas')) {
            foreach ($pengaduan->petugas as $petugas) {
                $notif = Notifikasi::create([
                    'id_user' => $petugas->id_user,
                    'id_pengaduan' => $pengaduan->id_pengaduan,
                    'type' => 'chat',
                    'title' => 'Balasan Baru dari User',
                    'pesan' => 'Ada balasan baru dari ' . $nama_user . ' pada pengaduan "' . $pengaduan->judul . '". Klik untuk melihat detail.',
                    'url' => route('backend.petugas.detailaduan', $pengaduan->id_pengaduan),
                    'is_read' => 0,
                ]);

                event(new UserNotification(
                    $petugas->id_user,
                    'Balasan Baru dari User',
                    'Ada balasan baru dari ' . $nama_user . ' pada pengaduan "' . $pengaduan->judul . '". Klik untuk melihat detail.',
                    route('backend.petugas.detailaduan', $pengaduan->id_pengaduan),
                    $notif->id_notifikasi
                ));
            }
        }
        // Jika belum ada relasi petugas, bisa juga broadcast ke semua user dengan role admin/petugas

        return back();
    }

    public function destroyAduan($id_pengaduan)
    {
        $aduan = Pengaduan::findOrFail($id_pengaduan);

        // Pastikan hanya user pemilik yang bisa hapus
        if ($aduan->id_user != auth()->user()->id_user) {
            abort(403, 'Akses tidak diizinkan');
        }

        // Hapus file foto jika ada
        if ($aduan->foto) {
            $fotoPath = public_path('storage/img-pengaduan/') . $aduan->foto;
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        // Hapus chat & tindak lanjut terkait (opsional)
        Chat::where('id_pengaduan', $aduan->id_pengaduan)->delete();
        // TindakLanjut::where('id_pengaduan', $aduan->id_pengaduan)->delete();

        $aduan->delete();

        // Broadcast event agar chart terupdate (realtime)
        event(new \App\Events\PengaduanUpdated());

        return redirect()->route('backend.user.riwayataduan')->with('success', 'Pengaduan berhasil dihapus.');
    }

    // Riwayat Tindak Lanjut User
    public function riwayatTindakLanjut()
    {
        $user = auth()->user();
        // Ambil semua tindak lanjut untuk aduan milik user ini
        $tindaklanjut = TindakLanjut::with(['pengaduan', 'petugas'])
            ->whereHas('pengaduan', function($q) use ($user) {
                $q->where('id_user', $user->id_user);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('backend.v_user.riwayat_tindaklanjut', [
            'judul' => 'Riwayat Tindak Lanjut',
            'tindaklanjut' => $tindaklanjut,
        ]);
    }

    // Detail Tindak Lanjut User
    public function detailTindakLanjut($id_tindak)
    {
        $tindak = TindakLanjut::with(['pengaduan', 'petugas'])->find($id_tindak);

        // Jika tidak ditemukan atau bukan milik user, redirect ke riwayat tindak lanjut
        if (
            !$tindak ||
            !$tindak->pengaduan ||
            $tindak->pengaduan->id_user != auth()->user()->id_user
        ) {
            return redirect()->route('backend.user.riwayat_tindaklanjut')
                ->with('error', 'Tindak lanjut tidak ditemukan atau sudah dihapus.');
        }

        return view('backend.v_user.detail_tindaklanjut', [
            'tindak' => $tindak
        ]);
    }
}
