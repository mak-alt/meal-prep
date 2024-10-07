<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointsColumnToAddonMealAndMealSideTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addon_meal', function (Blueprint $table) {
            $table->unsignedInteger('points')->after('price');
        });

        Schema::table('meal_side', function (Blueprint $table) {
            $table->unsignedInteger('points')->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addon_meal', function (Blueprint $table) {
            $table->dropColumn('points');
        });

        Schema::table('meal_side', function (Blueprint $table) {
            $table->dropColumn('points');
        });
    }
}
