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
        Schema::create('rubrik_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('komponen'); // LRK, Pelaksanaan, Disiplin, Kerjasama, Penghayatan, LPK
            $table->decimal('bobot', 5, 2); // dalam persen, misal 15.00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubrik_penilaian');
    }
};
