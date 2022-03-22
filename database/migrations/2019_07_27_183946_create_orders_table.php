<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->integer('customer_id')->nullable();
            $table->string('email')->nullable();
            $table->string('order_number')->nullable();
            $table->double('amount', 15, 2);
            $table->double('discount', 15, 2)->default(0.00);
            $table->string('error_msg')->nullable();
            $table->boolean('is_fulfilled')->default(0);
            $table->boolean('is_paid')->default(0);
            $table->boolean('is_bundle')->default(0);
            $table->boolean('pin_pay')->default(0);
            $table->boolean('online_pay')->default(0);
            $table->boolean('wallet_pay')->default(0);
            $table->softDeletes();
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
