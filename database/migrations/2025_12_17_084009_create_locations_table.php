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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('ptero_id_location')->unique();
            $table->timestamps();
        });

        // Table pivot Many-to-Many entre locations et plans
        Schema::create('location_plan', function (Blueprint $table) {
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->primary(['location_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer le pivot avant la table principale pour éviter les erreurs de contraintes
        Schema::dropIfExists('location_plan');
        Schema::dropIfExists('locations');
    }
};
