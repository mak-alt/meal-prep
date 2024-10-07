<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', Order::STATUSES)->default(Order::STATUSES['upcoming']);
            $table->unsignedDecimal('total_price');
            $table->unsignedDecimal('total_price_without_discounts');
            $table->unsignedInteger('total_points');
            $table->string('receiver_first_name');
            $table->string('receiver_last_name');
            $table->string('receiver_email');
            $table->string('receiver_company_name')->nullable();
            $table->date('delivery_date')->nullable()->default(null);
            $table->enum('delivery_time_frame', Order::TIME_FRAMES)->nullable()->default(null);
            $table->string('delivery_country')->nullable()->default(null);
            $table->string('delivery_state')->nullable()->default(null);
            $table->string('delivery_city')->nullable()->default(null);
            $table->string('delivery_street_address')->nullable()->default(null);
            $table->string('delivery_zip')->nullable()->default(null);
            $table->string('delivery_company_name')->nullable()->default(null);
            $table->string('delivery_phone_number')->nullable()->default(null);
            $table->string('delivery_order_notes')->nullable()->default(null);
            $table->date('pickup_date')->nullable()->default(null);
            $table->enum('pickup_time_frame', Order::TIME_FRAMES)->nullable()->default(null);
            $table->string('pickup_location')->nullable()->default(null);
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
        Schema::dropIfExists('orders');
    }
}
