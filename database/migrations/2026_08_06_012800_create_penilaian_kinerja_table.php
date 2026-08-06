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
        Schema::create('penilaian_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_kkn_id')->constrained('proyek_kkn')->cascadeOnDelete();
            $table->decimal('pelaksanaan', 5, 2); // bobot 30%
            $table->decimal('disiplin', 5, 2);    // bobot 15%
            $table->decimal('kerjasama', 5, 2);   // bobot 15%
            $table->decimal('penghayatan', 5, 2); // bobot 10%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kinerja');
    }
};
