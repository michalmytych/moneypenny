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
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table
                ->foreignId('import_setting_id')
                ->nullable()
                ->constrained('import_settings')
                ->nullOnDelete();
            $table
                ->foreignId('columns_mapping_id')
                ->nullable()
                ->constrained('columns_mappings')
                ->nullOnDelete();
            $table
                ->foreignId('file_id')
                ->nullable()
                ->constrained('files')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imports');
    }
};
