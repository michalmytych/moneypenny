<?php

use App\Moneypenny\Budget\Models\Budget;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table
                ->unsignedSmallInteger('type')
                ->default(Budget::TYPE_MONTH);
            $table
                ->decimal('amount')
                ->nullable();
            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
