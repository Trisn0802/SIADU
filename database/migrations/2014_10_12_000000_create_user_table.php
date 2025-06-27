<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->string('email')->unique();
            $table->string('instansi')->nullable();
            $table->enum('role', ['0', '1', '2'])->default('0'); // role user atau admin
            $table->tinyInteger(column: 'status')->default(value: 1); // 0 = banned, 1 = aktif
            $table->string('password');
            $table->string('no_hp')->nullable();
            $table->string('foto')->nullable();
            // $table->enum('isverified', ['0', '1'])->default('0');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};
