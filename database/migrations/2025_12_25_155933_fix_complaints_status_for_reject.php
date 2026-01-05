<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // ubah enum/status jadi string agar bisa nilai "ditolak"
            $table->string('status')->default('pending')->change();

            // pastikan kolom alasan ada (kalau sudah ada, abaikan)
            if (!Schema::hasColumn('complaints', 'rejection_reason')) {
                $table->string('rejection_reason', 255)->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // optional: kalau mau balik, tapi SQLite enum lama bisa bikin ribet
            // jadi biasanya dibiarkan kosong atau dibuat ulang manual
        });
    }
};
