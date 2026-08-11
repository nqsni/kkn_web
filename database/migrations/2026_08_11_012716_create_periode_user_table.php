<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_kkn')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role_saat_itu')->nullable();
            $table->timestamps();

            $table->unique(['periode_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_user');
    }
};