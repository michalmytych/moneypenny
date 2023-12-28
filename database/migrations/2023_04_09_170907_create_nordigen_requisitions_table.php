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
        Schema::create(
            'nordigen_requisitions', function (Blueprint $table) {
                $table->id();
                $table->uuid('reference');
                $table->json('raw_request_body');
                $table->json('raw_response_body');
                $table->string('link', 512);
                $table->string('nordigen_institution_id');
                $table->string('nordigen_requisition_id');
                $table
                    ->foreignId('end_user_agreement_id')
                    ->references('id')
                    ->on('nordigen_end_user_agreements')
                    ->cascadeOnDelete();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nordigen_requisitions');
    }
};
