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
        Schema::table('transactions', function (Blueprint $table) {
            $table
                ->foreignId('sender_persona_id')
                ->nullable()
                ->references('id')
                ->on('personas');
            $table
                ->foreignId('receiver_persona_id')
                ->nullable()
                ->references('id')
                ->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('sender_persona_id');
            $table->dropColumn('receiver_persona_id');
        });
    }
};
