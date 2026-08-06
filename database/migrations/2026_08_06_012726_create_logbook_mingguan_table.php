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
        Schema::create('logbook_mingguan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_kkn_id')->constrained('proyek_kkn')->cascadeOnDelete();
            $table->integer('minggu_ke');
            $table->string('file_logbook');
            $table->text('deskripsi_kegiatan')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_mingguan');
    }
};
