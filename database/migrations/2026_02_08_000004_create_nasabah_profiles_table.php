<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nasabah_profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->unique();
            $table->string('nik', 20)->unique();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->decimal('monthly_income', 14, 2)->nullable();
            $table->decimal('assets', 16, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nasabah_profiles');
    }
};
