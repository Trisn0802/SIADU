<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->foreignId('id_user')->constrained('user', 'id_user')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('kategori');
            $table->string('foto')->nullable();
            $table->string('lokasi');
            $table->dateTime('tanggal_lapor')->useCurrent();
            $table->enum('status', ['belum ditangani', 'diterima','diproses','ditolak', 'selesai'])->default('belum ditangani');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduan');
    }
};
