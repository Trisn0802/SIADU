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
        Schema::table('user', function (Blueprint $table) {
            // Tambahkan kolom uuid untuk setiap user (unik identifier)
            $table->string('uuid')->unique()->nullable()->after('id_user');

            // Tambahkan kolom untuk password reset token
            $table->string('reset_token')->unique()->nullable()->after('otp_verified');

            // Tambahkan kolom untuk waktu expires reset token
            $table->timestamp('reset_token_expires_at')->nullable()->after('reset_token');

            // Tambahkan index untuk UUID untuk query lebih cepat
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropIndex(['uuid']);
            $table->dropUnique(['uuid']);
            $table->dropUnique(['reset_token']);
            $table->dropColumn(['uuid', 'reset_token', 'reset_token_expires_at']);
        });
    }
};
