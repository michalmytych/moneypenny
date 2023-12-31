<?php

use App\Moneypenny\Transaction\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->nullable();
            $table->date('accounting_date')->nullable();
            $table->string('sender')->nullable();
            $table->string('raw_volume')->nullable();
            $table->decimal('decimal_volume')->nullable();
            $table
                ->unsignedTinyInteger('type')
                ->default(Transaction::TYPE_UNKNOWN)
                ->nullable();
            $table->string('receiver')->nullable();
            $table->text('description')->nullable();
            $table->string('currency')->nullable();
            $table
                ->foreignId('import_id')
                ->constrained('imports')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
