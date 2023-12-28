<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'transactions', function (Blueprint $table) {
                $table
                    ->boolean('is_excluded_from_calculation')
                    ->default(false);
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'transactions', function (Blueprint $table) {
                $table->dropColumn('is_excluded_from_calculation');
            }
        );
    }
};
