<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInPaymentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->dropColumn(['expiration_month', 'expiration_year', 'csc']);

            $table->string('stripe_card_id')->after('card_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_profiles', function (Blueprint $table) {
            $table->string('expiration_month')->after('card_number');
            $table->string('expiration_year')->after('expiration_month');
            $table->string('csc')->after('expiration_year');

            $table->dropColumn(['stripe_card_id']);
        });
    }
}
