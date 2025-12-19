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
        // On SQLite, you must drop the indexes before dropping the column
        if (Schema::hasColumn('users', 'pterodactyl_user_id')) {
            // Try to drop unique index
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique('users_pterodactyl_user_id_unique');
                });
            } catch (\Throwable $e) {}

            // Try to drop plain index
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropIndex('users_pterodactyl_user_id_index');
                });
            } catch (\Throwable $e) {}

            // Fallback for auto-generated names
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropUnique(['pterodactyl_user_id']);
                });
            } catch (\Throwable $e) {}

            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropIndex(['pterodactyl_user_id']);
                });
            } catch (\Throwable $e) {}

            // Now drop the column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('pterodactyl_user_id');
            });
        }
    }
};
