<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tindaklanjut', function (Blueprint $table) {
            $table->id('id_tindak');
            $table->foreignId('id_pengaduan')->constrained('pengaduan', 'id_pengaduan')->onDelete('cascade');
            // $table->foreignId('id_pengaduan')->nullable()->constrained('pengaduan', 'id_pengaduan');
            // $table->foreignId('id_pengaduan')->nullable()->constrained('pengaduan', 'id_pengaduan')->onDelete('set null');
            $table->foreignId('id_user')->nullable()->constrained('user', 'id_user')->onDelete('set null');
            $table->dateTime('tanggal_tindak')->useCurrent();
            $table->text('catatan')->nullable();
            $table->enum('status_akhir', ['diproses', 'selesai'])->default('diproses');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tindaklanjut');
    }
};
