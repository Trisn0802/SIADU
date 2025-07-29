<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduan_petugas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pengaduan')->unsigned();
            $table->bigInteger('id_user')->unsigned(); // id admin/petugas
            $table->enum('role_petugas', ['admin', 'petugas'])->default('petugas');
            $table->enum('status_penanganan', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('unassigned_at')->nullable();
            $table->timestamps();

            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');

            // Pastikan kombinasi pengaduan dan petugas unik
            $table->unique(['id_pengaduan', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan_petugas');
    }
};
