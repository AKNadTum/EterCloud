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
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('disk')->default(5120)->after('server_limit'); // MB (5 Go par défaut)
            $table->integer('backups_limit')->default(3)->after('disk');
            $table->integer('databases_limit')->default(1)->after('backups_limit');
            $table->integer('cpu')->default(0)->after('databases_limit'); // % (0 = illimité)
            $table->integer('memory')->default(0)->after('cpu'); // MB (0 = illimitée)
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['disk', 'backups_limit', 'databases_limit', 'cpu', 'memory']);
        });
    }
};
