<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addon_meal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('addon_id')->constrained('meals')->cascadeOnDelete();
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->unsignedDecimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addon_meal');
    }
}
