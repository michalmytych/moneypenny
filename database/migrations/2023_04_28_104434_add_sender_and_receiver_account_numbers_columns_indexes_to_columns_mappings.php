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
        Schema::table('columns_mappings', function (Blueprint $table) {
            $table->unsignedSmallInteger('sender_account_number_column_index')->nullable();
            $table->unsignedSmallInteger('receiver_account_number_column_index')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('columns_mappings', function (Blueprint $table) {
            $table->dropColumn('sender_account_number_column_index');
            $table->dropColumn('receiver_account_number_column_index');
        });
    }
};
