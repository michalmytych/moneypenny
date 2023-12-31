<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_accounts', function (Blueprint $table) {
            $table
                ->foreignId('account_id')
                ->nullable()
                ->constrained('accounts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('personal_accounts', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });
    }
};
