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
        Schema::create('proyek_kkn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->enum('status', ['diajukan', 'lolos', 'tidak_lolos'])->default('diajukan');
            $table->text('catatan_validasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek_kkn');
    }
};
