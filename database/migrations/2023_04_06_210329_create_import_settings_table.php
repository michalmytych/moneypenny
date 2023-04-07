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
        Schema::create('import_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('start_row');
            $table->string('file_extension');
            $table->string('delimiter');
            $table->string('enclosure')->nullable();
            $table->string('escape_character')->nullable();
            $table->string('input_encoding')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_settings');
    }
};
