<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('synchronizations', function (Blueprint $table) {
            $table
                ->smallInteger('code')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('synchronizations', function (Blueprint $table) {
            $table
                ->smallInteger('code')
                ->nullable(false)
                ->change();
        });
    }
};
