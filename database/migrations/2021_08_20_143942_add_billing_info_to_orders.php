<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingInfoToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('billing_country')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_street_address')->nullable();
            $table->string('billing_address_opt')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_company_name')->nullable();
            $table->string('billing_phone_number')->nullable();
            $table->string('billing_email_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('billing_country');
            $table->dropColumn('billing_state');
            $table->dropColumn('billing_city');
            $table->dropColumn('billing_street_address');
            $table->dropColumn('billing_address_opt');
            $table->dropColumn('billing_zip');
            $table->dropColumn('billing_company_name');
            $table->dropColumn('billing_phone_number');
            $table->dropColumn('billing_email_address');
        });
    }
}
