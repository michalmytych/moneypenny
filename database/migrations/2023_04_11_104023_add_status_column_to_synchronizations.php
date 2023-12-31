<?php

use App\Moneypenny\Synchronization\Models\Synchronization;
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
        Schema::table('synchronizations', function (Blueprint $table) {
            $table
                ->tinyInteger('status')
                ->default(Synchronization::SYNC_STATUS_RUNNING);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('synchronizations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
