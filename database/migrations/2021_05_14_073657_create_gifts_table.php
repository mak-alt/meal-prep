<?php

use App\Models\Gift;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->string('sender_name')->nullable();
            $table->foreignId('receiver_id')->nullable()->default(null)->constrained('users')->nullOnDelete();
            $table->enum('sent_via', Gift::DELIVERY_CHANNELS);
            $table->string('sent_to');
            $table->date('delivery_date')->default(null)->nullable();
            $table->unsignedInteger('amount');
            $table->text('message')->nullable();
            $table->string('code');
            $table->dateTime('used_at')->nullable()->default(null);
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
        Schema::dropIfExists('gifts');
    }
}
