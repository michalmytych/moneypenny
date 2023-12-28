<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'settings', function (Blueprint $table) {
                $table->id();
                $table
                    ->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();
                $table
                    ->string('base_currency_code')
                    ->default(config('moneypenny.base_calculation_currency'));
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
