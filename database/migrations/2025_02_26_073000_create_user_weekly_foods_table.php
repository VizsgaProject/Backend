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
        Schema::create('user_weekly_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('foods_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('dayOfWeek', ['Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat', 'Vasárnap']);
            $table->enum('mealType', ['Reggeli', 'Ebéd', 'Vacsora', 'Nasi']);
            $table->time('time');
            $table->float('quantity');
            $table->float('dailyCalorieTarget');
            $table->float('dailyProteinTarget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_weekly_foods');
    }
};
