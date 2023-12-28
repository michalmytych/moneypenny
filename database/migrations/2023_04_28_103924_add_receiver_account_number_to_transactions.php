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
        Schema::table(
            'transactions', function (Blueprint $table) {
                $table->string('receiver_account_number', 512)->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'transactions', function (Blueprint $table) {
                $table->dropColumn('receiver_account_number')->nullable();
            }
        );
    }
};
