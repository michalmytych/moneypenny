<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('synchronizations', function (Blueprint $table) {
            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('synchronizations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
