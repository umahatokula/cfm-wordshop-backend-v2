<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trxref')->comment('Ref generated from client');
            $table->string('transaction')->comment('Ref generated from server');
            $table->string('message')->comment('Msg recieved from server');
            $table->string('status')->comment('Status recieved from server');
            $table->integer('payment_type_id');
            $table->integer('pin_id')->nullable();
            $table->integer('order_id');
            $table->double('amount', 15, 2);
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
        Schema::dropIfExists('transactions');
    }
}
