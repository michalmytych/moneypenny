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
        Schema::create('columns_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('transaction_date_column_index')->nullable();
            $table->unsignedSmallInteger('accounting_date_column_index')->nullable();
            $table->unsignedSmallInteger('volume_column_index')->nullable();
            $table->unsignedSmallInteger('sender_column_index')->nullable();
            $table->unsignedSmallInteger('receiver_column_index')->nullable();
            $table->unsignedSmallInteger('description_column_index')->nullable();
            $table->unsignedSmallInteger('currency_column_index')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columns_mappings');
    }
};
