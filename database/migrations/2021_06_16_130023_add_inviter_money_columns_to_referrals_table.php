<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInviterMoneyColumnsToReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->unsignedInteger('inviter_money_gained')->after('user_first_order_at');
            $table->unsignedInteger('inviter_money_spent')->default(0)->after('inviter_money_gained');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropColumn(['inviter_money_gained', 'inviter_money_spent']);
        });
    }
}
