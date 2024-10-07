<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAdminMenus extends Migration
{
    public function up()
    {
        Schema::table('admin_menus', function (Blueprint $table) {
            $table->string('where_is')->nullable();
            $table->string('icon')->nullable();
        });
    }

    public function down()
    {
        Schema::table('admin_menus', function (Blueprint $table) {
            $table->dropColumn('where_is');
            $table->dropColumn('icon');
        });
    }
}
