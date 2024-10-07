<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePointsColumnToMealSideAndAddonMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meal_side', function (Blueprint $table) {
            $table->unsignedInteger('points')->after('price')->default(0)->change();
        });

        Schema::table('addon_meal', function (Blueprint $table) {
            $table->unsignedInteger('points')->after('price')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meal_side', function (Blueprint $table) {
            $table->unsignedInteger('points')->after('price')->change();
        });

        Schema::table('addon_meal', function (Blueprint $table) {
            $table->unsignedInteger('points')->after('price')->change();
        });
    }
}
