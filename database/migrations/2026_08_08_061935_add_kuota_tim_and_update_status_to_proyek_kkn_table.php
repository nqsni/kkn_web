<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyek_kkn', function (Blueprint $table) {
            $table->integer('kuota_tim')->default(1)->after('lokasi');
        });

        // Update enum status: tambah 'penuh'
        DB::statement("ALTER TABLE proyek_kkn MODIFY COLUMN status ENUM('diajukan', 'lolos', 'tidak_lolos', 'penuh') DEFAULT 'diajukan'");
    }

    public function down(): void
    {
        Schema::table('proyek_kkn', function (Blueprint $table) {
            $table->dropColumn('kuota_tim');
        });

        DB::statement("ALTER TABLE proyek_kkn MODIFY COLUMN status ENUM('diajukan', 'lolos', 'tidak_lolos') DEFAULT 'diajukan'");
    }
};