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
        Schema::create(
            'report_fields', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedTinyInteger('type');
                $table->string('value')->nullable();
                $table
                    ->foreignId('report_id')
                    ->references('id')
                    ->on('reports')
                    ->cascadeOnDelete();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_fields');
    }
};
