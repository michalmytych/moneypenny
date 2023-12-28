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
            'nordigen_end_user_agreements', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_successful')->default(false);
                $table->json('raw_request_body');
                $table->json('raw_response_body');
                $table->string('nordigen_institution_id')->nullable();
                $table->string('nordigen_end_user_agreement_id')->nullable();
                $table->dateTime('nordigen_end_user_agreement_created')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nordigen_end_user_agreements');
    }
};
