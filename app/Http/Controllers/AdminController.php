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

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aduanBaru = Pengaduan::where('status', 'belum ditangani')->count();
        $aduanDitolakHariIni = Pengaduan::where('status', 'ditolak')->whereDate('created_at', now())->count();
        $aduanDiprosesHariIni = Pengaduan::where('status', 'diproses')->whereDate('created_at', now())->count();
        $aduanHariIni = Pengaduan::whereDate('created_at', now())->count();
        $aduanBulanIni = Pengaduan::whereMonth('created_at', now()->month)->count();
        $totalPetugasAktif = User::where('role', '2')->where('status', 1)->count();

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

        return view('backend.v_beranda.index', compact(
            'aduanBaru', 'aduanDitolakHariIni', 'aduanDiprosesHariIni',
            'aduanHariIni', 'aduanBulanIni', 'totalPetugasAktif',
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
        $totalPetugasAktif = User::where('role', '2')->where('status', 1)->count();

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
            'totalPetugasAktif' => $totalPetugasAktif,
            'barData' => $barData,
            'pieData' => $pieData,
            'kategoriData' => $kategoriData,
        ]);
    }

    public function pengaduanList()
    {
        $pengaduan = Pengaduan::with('user')->orderByDesc('created_at')->get();
        return view('backend.v_admin.pengaduan', [
            'judul' => 'Data Pengaduan',
            'pengaduan' => $pengaduan,
        ]);
    }

    public function updatePengaduanStatus(Request $request, $id_pengaduan)
    {
        $request->validate([
            'status' => 'required|in:belum ditangani,diterima,diproses,ditolak,selesai'
        ]);
        $pengaduan = Pengaduan::with('user')->findOrFail($id_pengaduan);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        // Kirim chat otomatis sesuai status
        $statusPesan = [
            'diterima' => 'Aduan anda "' . $pengaduan->judul . '" telah diterima dan akan segera diproses.',
            'diproses' => 'Aduan anda "' . $pengaduan->judul . '" sedang diproses oleh petugas.',
            'ditolak' => 'Maaf, aduan anda "' . $pengaduan->judul . '" ditolak. Silakan cek riwayat percakapan aduan.',
            'selesai' => 'Aduan anda "' . $pengaduan->judul . '" telah selesai ditangani. Terima kasih.',
            'belum ditangani' => 'Aduan anda "' . $pengaduan->judul . '" menunggu verifikasi admin.'
        ];
        $pesan = $statusPesan[$request->status] ?? 'Status aduan "' . $pengaduan->judul . '" diperbarui.';

        // Kirim chat hanya jika status bukan "belum ditangani"
        if ($request->status != 'belum ditangani') {
            $chat = Chat::create([
                'id_pengaduan' => $id_pengaduan,
                'id_user' => auth()->user()->id_user,
                'pesan' => $pesan,
            ]);
            $chat->load('user');
            broadcast(new ChatSent($chat))->toOthers();
        }

        // Broadcast event status update
        event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
        event(new \App\Events\PengaduanUpdated());

        $user = $pengaduan->user;

        $notif = Notifikasi::create([
            'id_user' => $user->id_user,
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'type' => 'status',
            'title' => 'Status Pengaduan Diperbarui',
            'pesan' => 'Status pengaduan "' . $pengaduan->judul . '" Anda telah diperbarui menjadi: ' . ucfirst($pengaduan->status) . '. Klik untuk melihat detail.',
            'url' => route('backend.user.detailaduan', $pengaduan->id_pengaduan),
            'is_read' => 0,
        ]);

        event(new UserNotification(
            $user->id_user,
            'Status Pengaduan Diperbarui',
            'Status pengaduan "' . $pengaduan->judul . '" Anda telah diperbarui menjadi: ' . ucfirst($pengaduan->status) . '. Klik untuk melihat detail.',
            route('backend.user.detailaduan', $pengaduan->id_pengaduan),
            $notif->id_notifikasi
        ));

        // === Kirim Email ===
        $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
        $judul = 'Status Pengaduan Diperbarui';
        $pesan = $statusPesan[$request->status] ?? 'Status aduan "' . $pengaduan->judul . '" diperbarui.';
        $penanggap = auth()->user()->nama;
        $tanggal = Carbon::now()->format('Y-m-d H:i:s');
        $judulPengaduan = $pengaduan->judul;
        $url = route('backend.user.detailaduan', $pengaduan->id_pengaduan);
        Mail::to($user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

        return redirect()->back()->with('success', 'Status pengaduan berhasil diubah!');
    }

    public function destroyPengaduan($id_pengaduan)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id_pengaduan);
        $user = $pengaduan->user;

        // Hapus file foto jika ada
        if ($pengaduan->foto) {
            $fotoPath = public_path('storage/img-pengaduan/') . $pengaduan->foto;
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }

        // Hapus chat & tindak lanjut terkait (opsional)
        Chat::where('id_pengaduan', $pengaduan->id_pengaduan)->delete();
        TindakLanjut::where('id_pengaduan', $pengaduan->id_pengaduan)->delete();

        $pengaduan->delete();

        // Notifikasi ke user pembuat pengaduan
        $notif = Notifikasi::create([
            'id_user' => $user->id_user,
            'type' => 'pengaduan',
            'title' => 'Pengaduan Dihapus',
            'pesan' => "Pengaduan \"{$pengaduan->judul}\" Anda telah dihapus oleh admin.",
            'url' => route('backend.user.riwayataduan'),
            'is_read' => 0,
        ]);
        event(new UserNotification(
            $user->id_user,
            'Pengaduan Dihapus',
            "Pengaduan \"{$pengaduan->judul}\" Anda telah dihapus oleh admin.",
            route('backend.user.riwayataduan'),
            $notif->id_notifikasi
        ));

        // Broadcast event agar chart dashboard terupdate
        event(new \App\Events\PengaduanUpdated());

        // === Kirim Email ===
        $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
        $judul = 'Pengaduan Anda Dihapus';
        $pesan = "Pengaduan Anda telah dihapus oleh admin.";
        $penanggap = auth()->user()->nama;
        $tanggal = Carbon::now()->format('Y-m-d H:i:s');
        $judulPengaduan = $pengaduan->judul;
        $url = route('backend.user.riwayataduan');
        Mail::to($user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

        return redirect()->route('backend.admin.pengaduan')->with('success', 'Pengaduan berhasil dihapus!');
    }

    public function sendChat(Request $request, $id_pengaduan)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        $pengaduan = Pengaduan::with('user')->findOrFail($id_pengaduan);
        $user = $pengaduan->user;

        $chat = Chat::create([
            'id_pengaduan' => $id_pengaduan,
            'id_user' => auth()->user()->id_user,
            'pesan' => $request->pesan,
        ]);

        $chat->load('user');

        broadcast(new ChatSent($chat))->toOthers();

        // Notifikasi untuk user pengadu dari admin, sertakan judul pengaduan
        $notif = Notifikasi::create([
            'id_user' => $user->id_user,
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'type' => 'chat',
            'title' => 'Pesan Baru dari Admin',
            'pesan' => 'Anda menerima pesan baru dari admin pada pengaduan: "' . $pengaduan->judul . '". Klik untuk melihat detail.',
            'url' => route('backend.user.detailaduan', $pengaduan->id_pengaduan),
            'is_read' => 0,
        ]);

        event(new UserNotification(
            $user->id_user,
            'Pesan Baru dari Admin',
            'Anda menerima pesan baru dari admin pada pengaduan: "' . $pengaduan->judul . '". Klik untuk melihat detail.',
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

    public function detailAduan($id_pengaduan)
    {
        $aduan = Pengaduan::with('user')->find($id_pengaduan);
        if (!$aduan) {
            return redirect()->route('backend.admin.pengaduan')->with('error', 'Pengaduan tidak ditemukan atau sudah dihapus.');
        }
        $chats = Chat::where('id_pengaduan', $id_pengaduan)->orderBy('created_at')->get();
        return view('backend.v_admin.aduandetailadmin', compact('aduan', 'chats'));
    }

    public function cetakAduan($id_pengaduan)
    {
        $aduan = Pengaduan::with('user')->findOrFail($id_pengaduan);
        return view('backend.v_admin.cetak_aduan', compact('aduan'));
    }

    public function showUser()
    {
        // Hanya role 1 (Admin) dan 2 (Petugas)
        $user = User::whereIn('role', ['1', '2'])->orderBy('updated_at', 'desc')->get();
        return view('backend.v_admin.index', [
            'judul' => 'Data Admin & Petugas',
            'index' => $user
        ]);
    }

    public function showUserMasyarakat()
    {
        // Hanya role 0 (User/Masyarakat)
        $user = User::where('role', '0')->orderBy('updated_at', 'desc')->get();
        return view('backend.v_admin.user_masyarakat', [
            'judul' => 'Data User/Masyarakat',
            'index' => $user
        ]);
    }

    public function banUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status; // 1 = aktif, 0 = banned
        $user->save();
        return redirect()->back()->with('success', 'Status user berhasil diubah.');
    }

    public function createUser()
    {
        return view('backend.v_admin.create', [
            'judul' => 'Tambah Petugas Dan Admin',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nik' => 'nullable|max:16|unique:user',
            'instansi'=> 'nullable',
            'email' => 'required|max:255|email|unique:user',
            'role' => 'required',
            'no_hp' => 'required|min:10|max:13',
            'password' => 'required|min:4|confirmed',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ], [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ]);

        $validatedData['status'] = 1; // Default status aktif

        // Password validation
        $password = $request->input('password');
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

        if (!preg_match($pattern, $password)) {
            return redirect()->back()->withErrors([
                'password' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol karakter.'
            ]);
        }

        // Handle image upload only if all inputs are valid
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-user/';

            // Save image with specified dimensions
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);
            $validatedData['foto'] = $originalFileName;
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('backend.user.showUser')
            ->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUser(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.v_admin.edit', [
            'judul' => 'Ubah User',
            'edit' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama' => 'required|max:255',
            'nik' => 'nullable|max:16|unique:user',
            'instansi'=> 'nullable',
            'role' => 'required',
            'status' => 'required',
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
            ->route('backend.user.showUser')
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

        return view('backend.v_admin.gantipassword', [
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

        return redirect()->route('backend.beranda')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->foto) {
            $oldImagePath = public_path('storage/img-user/') . $user->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $user->delete();

        return redirect()->back()->with('success', 'Data user berhasil dihapus.');
    }

    public function formUser()
    {
        return view('backend.v_admin.form', [
            'judul' => 'Laporan Data User',
            ]);
    }
    public function cetakUser(Request $request)
        {
        // Menambahkan aturan validasi
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            ], [
            'tanggal_awal.required' => 'Tanggal Awal harus diisi.',
            'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.',
            'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama
            dengan Tanggal Awal.',
        ]);
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $query = User::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->orderBy('id', 'desc');
        $user = $query->get();
        return view('backend.v_admin.cetak', [
            'judul' => 'Laporan User',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $user
        ]);
    }

    public function tindaklanjutIndex()
    {
        // Relasi 'petugas' = user yang membuat tindak lanjut
        $tindaklanjut = TindakLanjut::with(['pengaduan', 'petugas'])
            ->orderByDesc('created_at')
            ->get();

        return view('backend.v_admin.tindaklanjut_index', [
            'judul'=> 'Daftar Tindak Lanjut Petugas',
            'tindaklanjut'=> $tindaklanjut
        ]);
    }

    public function tindaklanjutPetugas()
    {
        $tindaklanjut = TindakLanjut::with(['pengaduan'])
            ->where('id_user', auth()->user()->id_user)
            ->orderByDesc('created_at')
            ->get();

        return view('backend.v_admin.riwayat_tindaklanjut', [
            'judul'=> 'Riwayat Tindak Lanjut',
            'tindaklanjut'=> $tindaklanjut
        ]);
    }

    public function tindaklanjutBelumSelesai()
    {
        $tindaklanjut = TindakLanjut::with(['pengaduan', 'petugas'])
            ->where('status_akhir', '!=', 'selesai')
            ->orderByDesc('created_at')
            ->get();

        return view('backend.v_admin.tindaklanjut_belumselesai', [
            'judul'=> 'Tindak Lanjut Belum Selesai',
            'tindaklanjut'=> $tindaklanjut
        ]);
    }

    // Form tambah tindak lanjut
    public function tindaklanjutCreate($id_pengaduan)
    {
        $pengaduan = Pengaduan::findOrFail($id_pengaduan);

        // Hanya boleh jika status diterima/diproses dan belum selesai
        if (!in_array($pengaduan->status, ['diterima', 'diproses'])) {
            return back()->with('error', 'Tindak lanjut hanya bisa dilakukan jika status pengaduan diterima atau diproses.');
        }

        return view('backend.v_admin.tindaklanjut_create', [
            'judul'=> 'Tindak Lanjut',
            'pengaduan'=> $pengaduan
        ]);
    }

    public function detailTindakLanjut($id_tindak)
    {
        $tindak = TindakLanjut::with(['pengaduan.user', 'petugas'])->find($id_tindak);
        if (!$tindak) {
            return redirect()->route('backend.tindaklanjut.index')->with('error', 'Tindak lanjut tidak ditemukan atau dihapus.');
        }
        return view('backend.v_admin.detail_tindaklanjut', compact('tindak'));
    }

    // Simpan tindak lanjut
    public function tindaklanjutStore(Request $request)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduan,id_pengaduan',
            'tanggal_tindak' => 'required|date',
            'catatan' => 'required',
            'status_akhir' => 'required|in:diproses,selesai',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $pengaduan = Pengaduan::findOrFail($request->id_pengaduan);

        // Cek status pengaduan
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

        // Kirim chat otomatis sesuai status
        $statusPesan = [
            'diproses' => 'Aduan anda "' . $pengaduan->judul . '" sedang diproses oleh Admin, silahkan cek di menu riwayat tindak lanjut.',
            'ditolak' => 'Maaf, aduan anda "' . $pengaduan->judul . '" ditolak. Silakan cek riwayat percakapan aduan.',
            'selesai' => 'Aduan anda "' . $pengaduan->judul . '" telah selesai ditangani. Terima kasih, silahkan cek di menu riwayat tindak lanjut.',
        ];
        $pesan = $statusPesan[$request->status_akhir] ?? 'Status aduan "' . $pengaduan->judul . '" diperbarui.';

        // Kirim chat hanya jika status_akhir bukan "belum ditangani"
        if ($request->status_akhir != 'belum ditangani') {
            $chat = Chat::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_user' => auth()->user()->id_user,
                'pesan' => $pesan,
            ]);
            $chat->load('user');
            broadcast(new ChatSent($chat))->toOthers();
        }

        // Jika status pengaduan masih "diterima", ubah ke "diproses"
        if ($pengaduan->status == 'diterima') {
            $pengaduan->status = 'diproses';
            $pengaduan->save();

            // Broadcast event status update
            event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
            event(new \App\Events\PengaduanUpdated());
        }

        // Jika status akhir tindak lanjut "selesai", ubah status pengaduan ke "selesai"
        if ($request->status_akhir == 'selesai') {
            $pengaduan->status = 'selesai';
            $pengaduan->save();

            // Broadcast event status update
            event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
            event(new \App\Events\PengaduanUpdated());
        }

        // Simpan data tindak lanjut
        $tindaklanjut = TindakLanjut::create($data);

        Notifikasi::create([
            'id_user' => $pengaduan->user->id_user,
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'type' => 'tindaklanjut',
            'title' => 'Tindak Lanjut Baru',
            'pesan' => 'Pengaduan "' . $pengaduan->judul . '" Anda telah ditindak lanjuti. Klik untuk melihat detail.',
            'url' => route('backend.user.detail_tindaklanjut', $tindaklanjut->id_tindak),
            'is_read' => 0,
        ]);
        event(new UserNotification(
            $pengaduan->user->id_user,
            'Tindak Lanjut Baru',
            'Pengaduan "' . $pengaduan->judul . '" Anda telah ditindak lanjuti. Klik untuk melihat detail.',
            route('backend.user.detail_tindaklanjut', $tindaklanjut->id_tindak)
        ));

        // Kirim Email
        $judul = 'Pengaduan Anda ditanggapi ' . auth()->user()->nama;
        $pesan = $request->catatan;
        $penanggap = auth()->user()->nama;
        $tanggal = Carbon::now()->format('Y-m-d H:i:s');
        $judulPengaduan = $pengaduan->judul;
        $url = route('backend.user.detail_tindaklanjut', $tindaklanjut->id_tindak);
        Mail::to($pengaduan->user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url));

        return redirect()->route('backend.admin.tindaklanjut.petugas')->with('success', 'Tindak lanjut berhasil disimpan');
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

            // Buat Notifikasi
            Notifikasi::create([
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
                route('backend.user.detailaduan', $pengaduan->id_pengaduan)
            ));

            // === Kirim Email ===
            $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
            $judul = 'Tindak Lanjut Dihapus';
            $pesan = 'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin.';
            $penanggap = auth()->user()->nama;
            $tanggal = Carbon::now()->format('Y-m-d H:i:s');
            $judulPengaduan = $pengaduan->judul;
            $url = route('backend.user.detailaduan', $pengaduan->id_pengaduan);
            Mail::to($pengaduan->user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));

        } elseif ($lastTindak && $pengaduan) {
            // Jika masih ada tindak lanjut, update status pengaduan sesuai status_akhir tindak lanjut terakhir
            $pengaduan->status = $lastTindak->status_akhir == 'selesai' ? 'selesai' : 'diproses';
            $pengaduan->save();

            // Kirim chat otomatis ke user
            $pesan = $lastTindak->status_akhir == 'selesai'
                ? 'Tindak lanjut terakhir dihapus. Status pengaduan anda kini selesai.'
                : 'Tindak lanjut terakhir dihapus. Status pengaduan anda kini diproses.';
            $chat = Chat::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_user' => auth()->user()->id_user,
                'pesan' => $pesan,
            ]);
            $chat->load('user');
            broadcast(new ChatSent($chat))->toOthers();

            event(new PengaduanStatusUpdated($pengaduan->id_pengaduan, $pengaduan->status));
            event(new \App\Events\PengaduanUpdated());

            // Buat Notifikasi
            Notifikasi::create([
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
                route('backend.user.detailaduan', $pengaduan->id_pengaduan)
            ));

            // === Kirim Email ===
            $role = auth()->user()->role == 1 ? 'Admin' : (auth()->user()->role == 2 ? 'Petugas' : 'User');
            $judul = 'Tindak Lanjut Dihapus';
            $pesan = 'Tindak lanjut dari "' . $pengaduan->judul . '" telah dihapus oleh petugas/admin.';
            $penanggap = auth()->user()->nama;
            $tanggal = Carbon::now()->format('Y-m-d H:i:s');
            $judulPengaduan = $pengaduan->judul;
            $url = route('backend.user.detailaduan', $pengaduan->id_pengaduan);
            Mail::to($pengaduan->user->email)->send(new NotifikasiUserMail($judul, $pesan, $penanggap, $tanggal, $judulPengaduan, $url, $role));
        }

        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus.');
    }

    // Form laporan user
    public function formLaporanUser() {
        return view('backend.v_admin.form', ['judul' => 'Laporan Data User', 'action' => route('backend.laporan.cetakuser')]);
    }

    // Form laporan petugas & admin
    public function formLaporanPetugasAdmin() {
        return view('backend.v_admin.form', ['judul' => 'Laporan Data Petugas & Admin', 'action' => route('backend.laporan.cetakpetugasadmin')]);
    }

    // Form laporan pengaduan
    public function formLaporanPengaduan() {
        return view('backend.v_admin.form', ['judul' => 'Laporan Data Pengaduan', 'action' => route('backend.laporan.cetakpengaduan')]);
    }

    // Form laporan tindak lanjut
    public function formLaporanTindakLanjut() {
        return view('backend.v_admin.form', ['judul' => 'Laporan Data Tindak Lanjut', 'action' => route('backend.laporan.cetaktindaklanjut')]);
    }

    // Cetak laporan user
    public function cetakLaporanUser(Request $request) {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        $data = User::where('role', '0')
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->get();
        return view('backend.v_admin.cetak_user', [
            'nama_aplikasi'=> 'SIADU',
            'judul' => 'Laporan Data User',
            'tanggalAwal' => $request->tanggal_awal,
            'tanggalAkhir' => $request->tanggal_akhir,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    // Cetak laporan petugas & admin
    public function cetakLaporanPetugasAdmin(Request $request) {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        $data = User::whereIn('role', ['1','2'])
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->get();
        return view('backend.v_admin.cetak_petugasadmin', [
            'nama_aplikasi'=> 'SIADU',
            'judul' => 'Laporan Data Petugas & Admin',
            'tanggalAwal' => $request->tanggal_awal,
            'tanggalAkhir' => $request->tanggal_akhir,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    // Cetak laporan pengaduan
    public function cetakLaporanPengaduan(Request $request) {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        $data = Pengaduan::with('user')
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->get();
        return view('backend.v_admin.cetak_pengaduan', [
            'nama_aplikasi'=> 'SIADU',
            'judul' => 'Laporan Data Pengaduan',
            'tanggalAwal' => $request->tanggal_awal,
            'tanggalAkhir' => $request->tanggal_akhir,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

    // Cetak laporan tindak lanjut
    public function cetakLaporanTindakLanjut(Request $request) {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        $data = TindakLanjut::with(['pengaduan', 'petugas'])
            ->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->get();
        return view('backend.v_admin.cetak_tindaklanjut', [
            'nama_aplikasi'=> 'SIADU',
            'judul' => 'Laporan Data Tindak Lanjut',
            'tanggalAwal' => $request->tanggal_awal,
            'tanggalAkhir' => $request->tanggal_akhir,
            'data' => $data,
            'total' => $data->count()
        ]);
    }

}
