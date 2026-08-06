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
        Schema::create('nilai_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_kkn_id')->constrained('proyek_kkn')->cascadeOnDelete();
            $table->decimal('nilai_lrk', 5, 2);
            $table->decimal('nilai_kinerja', 5, 2);
            $table->decimal('nilai_lpk', 5, 2);
            $table->decimal('nilai_akhir', 5, 2); // hasil gabungan
            $table->string('nilai_mutu', 2); // A, AB, B, BC, C, D, E
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_akhir');
    }
};
