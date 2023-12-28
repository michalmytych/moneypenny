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
        Schema::table('report_fields', function (Blueprint $table) {
            $table
                ->foreignId('parent_report_field_id')
                ->nullable()
                ->references('id')
                ->on('report_fields')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_fields', function (Blueprint $table) {
            $table->dropColumn('parent_report_field_id');
        });
    }
};
