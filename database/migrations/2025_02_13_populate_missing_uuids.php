<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate UUIDs for any users that don't have one
        $users = DB::table('user')->whereNull('uuid')->get();

        foreach ($users as $user) {
            DB::table('user')
                ->where('id_user', $user->id_user)
                ->update(['uuid' => (string) Str::uuid()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration can't be easily reversed as it fills in missing data
        // If needed, set all UUIDs to null
        DB::table('user')->update(['uuid' => null]);
    }
};
