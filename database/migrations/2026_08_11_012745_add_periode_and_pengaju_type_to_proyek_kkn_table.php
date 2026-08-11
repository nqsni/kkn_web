<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Guard: jangan tambah kolom kalau sudah ada (biar bisa dijalankan ulang dengan aman)
        if (!Schema::hasColumn('proyek_kkn', 'periode_id')) {
            Schema::table('proyek_kkn', function (Blueprint $table) {
                $table->foreignId('periode_id')->nullable()->after('id')->constrained('periode_kkn')->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('proyek_kkn', 'pengaju_type')) {
            Schema::table('proyek_kkn', function (Blueprint $table) {
                $table->enum('pengaju_type', ['mahasiswa', 'dosen'])->default('mahasiswa')->after('periode_id');
            });
        }

        // Lepas & pasang ulang FK mahasiswa_id supaya bisa nullable (aman dijalankan ulang)
        DB::statement('ALTER TABLE proyek_kkn DROP FOREIGN KEY proyek_kkn_mahasiswa_id_foreign');
        DB::statement('ALTER TABLE proyek_kkn MODIFY mahasiswa_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE proyek_kkn ADD CONSTRAINT proyek_kkn_mahasiswa_id_foreign FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE');

        // STEP 1: perluas enum dulu, biar 'lolos' (lama) & 'tersedia' (baru) sama-sama valid sementara
        DB::statement("ALTER TABLE proyek_kkn MODIFY COLUMN status ENUM('diajukan', 'lolos', 'tidak_lolos', 'menunggu_rilis', 'tersedia', 'penuh') DEFAULT 'diajukan'");

        // STEP 2: migrasikan data lama 'lolos' -> 'tersedia'
        DB::table('proyek_kkn')->where('status', 'lolos')->update(['status' => 'tersedia']);

        // STEP 3: persempit enum ke daftar final (hapus 'lolos')
        DB::statement("ALTER TABLE proyek_kkn MODIFY COLUMN status ENUM('diajukan', 'tidak_lolos', 'menunggu_rilis', 'tersedia', 'penuh') DEFAULT 'diajukan'");
    }

    public function down(): void
    {
        if (Schema::hasColumn('proyek_kkn', 'periode_id')) {
            Schema::table('proyek_kkn', function (Blueprint $table) {
                $table->dropForeign(['periode_id']);
                $table->dropColumn('periode_id');
            });
        }

        if (Schema::hasColumn('proyek_kkn', 'pengaju_type')) {
            Schema::table('proyek_kkn', function (Blueprint $table) {
                $table->dropColumn('pengaju_type');
            });
        }

        DB::statement("ALTER TABLE proyek_kkn MODIFY COLUMN status ENUM('diajukan', 'lolos', 'tidak_lolos', 'penuh') DEFAULT 'diajukan'");
    }
};