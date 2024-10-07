<?php

use App\Models\PaymentHistory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('payment_service', PaymentHistory::PAYMENT_SERVICE_NAMES);
            $table->unsignedDecimal('amount');
            $table->string('transaction_id');
            $table->string('status');
            $table->integer('card_last_4')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt_url')->nullable();
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
        Schema::dropIfExists('payment_histories');
    }
}
