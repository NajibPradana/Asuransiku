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
        Schema::table('policies', function (Blueprint $table) {
            $table->foreignId('renewal_from_policy_id')
                ->nullable()
                ->constrained('policies')
                ->nullOnDelete()
                ->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('policies', function (Blueprint $table) {
            $table->dropForeign(['renewal_from_policy_id']);
            $table->dropColumn('renewal_from_policy_id');
        });
    }
};
