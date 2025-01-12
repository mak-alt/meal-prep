<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedDecimal('price');
            $table->json('tags')->nullable();
            $table->string('thumb')->nullable();
            $table->unsignedInteger('calories');
            $table->unsignedInteger('fats');
            $table->unsignedInteger('carbs');
            $table->unsignedInteger('proteins');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('meals');
    }
}
