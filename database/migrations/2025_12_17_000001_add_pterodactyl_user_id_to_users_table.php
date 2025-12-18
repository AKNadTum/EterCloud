<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Identifiant utilisateur Pterodactyl (Application API). Nullable tant que non lié.
            $table->unsignedBigInteger('pterodactyl_user_id')
                ->nullable()
                ->unique()
                ->after('id');
        });
    }

    public function down(): void
    {
        // On SQLite, you must drop the unique index before dropping the column
        if (Schema::hasColumn('users', 'pterodactyl_user_id')) {
            // Try to drop the unique index first (ignore errors if it doesn't exist)
            try {
                Schema::table('users', function (Blueprint $table) {
                    // Default Laravel unique index name: {table}_{column}_unique
                    $table->dropUnique('users_pterodactyl_user_id_unique');
                });
            } catch (\Throwable $e) {
                // Fallback: ask Laravel to infer the index name from the column
                try {
                    Schema::table('users', function (Blueprint $table) {
                        $table->dropUnique(['pterodactyl_user_id']);
                    });
                } catch (\Throwable $e2) {
                    // no-op
                }
            }

            // Now drop the column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('pterodactyl_user_id');
            });
        }
    }
};
