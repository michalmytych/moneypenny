<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nordigen_end_user_agreements', function (Blueprint $table) {
            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('nordigen_end_user_agreements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
