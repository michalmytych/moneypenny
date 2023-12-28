<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('synchronizations', function (Blueprint $table) {
            $table->smallInteger('code');
        });
    }

    public function down(): void
    {
        Schema::table('synchronizations', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
