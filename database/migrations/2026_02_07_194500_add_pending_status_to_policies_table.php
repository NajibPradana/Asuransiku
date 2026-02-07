<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE policies MODIFY status ENUM('pending', 'active', 'expired', 'cancelled') DEFAULT 'pending'");
        }
        // For PostgreSQL and other databases, use a different approach
        else {
            Schema::table('policies', function (Blueprint $table) {
                $table->dropColumn('status');
            });

            Schema::table('policies', function (Blueprint $table) {
                $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])->default('pending');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE policies MODIFY status ENUM('active', 'expired', 'cancelled') DEFAULT 'active'");
        } else {
            Schema::table('policies', function (Blueprint $table) {
                $table->dropColumn('status');
            });

            Schema::table('policies', function (Blueprint $table) {
                $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            });
        }
    }
};
