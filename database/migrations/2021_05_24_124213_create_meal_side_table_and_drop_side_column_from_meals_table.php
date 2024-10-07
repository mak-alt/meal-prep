<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealSideTableAndDropSideColumnFromMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_side', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('side_id')->constrained('meals')->cascadeOnDelete();
            $table->unsignedDecimal('price');
            $table->timestamps();
        });

        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn('side');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_side');

        Schema::table('meals', function (Blueprint $table) {
            $table->text('side')->nullable()->after('price');
        });
    }
}
