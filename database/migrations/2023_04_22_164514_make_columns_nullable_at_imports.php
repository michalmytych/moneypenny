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
            'imports', function (Blueprint $table) {
                $table->foreignId('import_setting_id')->nullable()->change();
                $table->foreignId('columns_mapping_id')->nullable()->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'imports', function (Blueprint $table) {
                $table->foreignId('import_setting_id')->nullable(false)->change();
                $table->foreignId('columns_mapping_id')->nullable(false)->change();
            }
        );
    }
};
