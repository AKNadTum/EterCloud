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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable()->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // On SQLite, dropping a column that still has an index will fail.
        // Drop the index first, then drop the column if it exists.
        if (Schema::hasColumn('users', 'stripe_customer_id')) {
            // Drop index safely (ignore if it doesn't exist)
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropIndex('users_stripe_customer_id_index');
                });
            } catch (\Throwable $e) {
                // no-op
            }

            // Now drop the column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('stripe_customer_id');
            });
        }
    }
};
