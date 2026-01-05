<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 120);
            $table->text('description');
            $table->string('evidence_path')->nullable();

            // ✅ gunakan string agar bisa: pending/diproses/selesai/ditolak
            $table->string('status', 20)->default('pending');

            // ✅ alasan penolakan (kalau sudah ada migration add, ini boleh dihapus dari sini)
            $table->string('rejection_reason', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
