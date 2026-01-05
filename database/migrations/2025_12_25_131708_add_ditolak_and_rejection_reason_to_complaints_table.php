<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // tambah kolom alasan penolakan
        Schema::table('complaints', function (Blueprint $table) {
            if (!Schema::hasColumn('complaints', 'rejection_reason')) {
                $table->string('rejection_reason', 255)->nullable()->after('status');
            }
        });

        // tambah status 'ditolak' bila DB MySQL/MariaDB
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE complaints MODIFY status ENUM('pending','diproses','selesai','ditolak') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        // hapus kolom alasan
        Schema::table('complaints', function (Blueprint $table) {
            if (Schema::hasColumn('complaints', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
        });

        // kembalikan enum bila MySQL/MariaDB
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE complaints MODIFY status ENUM('pending','diproses','selesai') NOT NULL DEFAULT 'pending'");
        }
    }
};
