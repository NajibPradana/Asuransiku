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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();

            $table->string('claim_number')->unique();

            $table->foreignId('policy_id')->constrained()->cascadeOnDelete();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('incident_date');

            $table->text('description')->nullable();

            $table->decimal('amount_claimed', 12, 2)->nullable();
            $table->decimal('amount_approved', 12, 2)->nullable();

            $table->json('evidence_files')->nullable();

            $table->enum('status', [
                'pending',
                'review',
                'approved',
                'rejected',
                'paid'
            ])->default('pending');

            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
