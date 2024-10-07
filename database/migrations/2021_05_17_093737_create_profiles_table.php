<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('display_name')->nullable()->default(null);
            $table->string('delivery_first_name')->nullable()->default(null);
            $table->string('delivery_last_name')->nullable()->default(null);
            $table->string('delivery_country')->nullable()->default(null);
            $table->string('delivery_state')->nullable()->default(null);
            $table->string('delivery_city')->nullable()->default(null);
            $table->string('delivery_street_address')->nullable()->default(null);
            $table->string('delivery_zip')->nullable()->default(null);
            $table->string('delivery_company_name')->nullable()->default(null);
            $table->string('billing_first_name')->nullable()->default(null);
            $table->string('billing_last_name')->nullable()->default(null);
            $table->string('billing_country')->nullable()->default(null);
            $table->string('billing_state')->nullable()->default(null);
            $table->string('billing_city')->nullable()->default(null);
            $table->string('billing_street_address')->nullable()->default(null);
            $table->string('billing_zip')->nullable()->default(null);
            $table->string('billing_company_name')->nullable()->default(null);
            $table->string('billing_phone_number')->nullable()->default(null);
            $table->string('billing_email_address')->nullable()->default(null);
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
        Schema::dropIfExists('profiles');
    }
}
