<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\PengaduanPetugas;
use App\Models\User;

class AssignExistingPetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua pengaduan yang sudah ada
        $pengaduan = Pengaduan::all();

        // Ambil admin dan petugas
        $admins = User::where('role', '1')->where('status', 1)->get();
        $petugas = User::where('role', '2')->where('status', 1)->get();

        foreach ($pengaduan as $aduan) {
            // Jika pengaduan sudah memiliki assigned_petugas, assign petugas tersebut
            if ($aduan->assigned_petugas) {
                $assignedUser = User::find($aduan->assigned_petugas);
                if ($assignedUser) {
                    $role = $assignedUser->role == '1' ? 'admin' : 'petugas';

                    PengaduanPetugas::create([
                        'id_pengaduan' => $aduan->id_pengaduan,
                        'id_user' => $assignedUser->id_user,
                        'role_petugas' => $role,
                        'status_penanganan' => 'aktif',
                        'assigned_at' => $aduan->created_at,
                    ]);
                }
            } else {
                // Jika tidak ada assigned_petugas, assign admin pertama dan petugas pertama
                if ($admins->count() > 0) {
                    PengaduanPetugas::create([
                        'id_pengaduan' => $aduan->id_pengaduan,
                        'id_user' => $admins->first()->id_user,
                        'role_petugas' => 'admin',
                        'status_penanganan' => 'aktif',
                        'assigned_at' => $aduan->created_at,
                    ]);

                    // Update assigned_petugas di tabel pengaduan
                    $aduan->update(['assigned_petugas' => $admins->first()->id_user]);
                }

                if ($petugas->count() > 0) {
                    PengaduanPetugas::create([
                        'id_pengaduan' => $aduan->id_pengaduan,
                        'id_user' => $petugas->first()->id_user,
                        'role_petugas' => 'petugas',
                        'status_penanganan' => 'aktif',
                        'assigned_at' => $aduan->created_at,
                    ]);

                    // Jika belum ada assigned_petugas, set ke petugas pertama
                    if (!$aduan->assigned_petugas) {
                        $aduan->update(['assigned_petugas' => $petugas->first()->id_user]);
                    }
                }
            }
        }

        $this->command->info('Petugas berhasil diassign ke pengaduan yang sudah ada!');
    }
}
