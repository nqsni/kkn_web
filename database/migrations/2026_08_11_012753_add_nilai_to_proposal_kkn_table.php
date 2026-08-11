<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_kkn', function (Blueprint $table) {
            $table->decimal('nilai', 5, 2)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_kkn', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }
};