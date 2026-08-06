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
        Schema::create('proposal_kkn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_kkn_id')->constrained('proyek_kkn')->cascadeOnDelete();
            $table->string('file_proposal'); // path file
            $table->enum('status', ['diajukan', 'acc', 'ditolak'])->default('diajukan');
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_kkn');
    }
};
