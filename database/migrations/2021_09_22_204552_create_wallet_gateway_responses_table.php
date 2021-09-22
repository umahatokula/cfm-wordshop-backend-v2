<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletGatewayResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_gateway_responses', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->string('redirecturl')->nullable();
            $table->string('reference')->nullable();
            $table->string('status')->nullable();
            $table->string('trans')->nullable();
            $table->string('transaction')->nullable();
            $table->string('trxref')->nullable();
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
        Schema::dropIfExists('wallet_gateway_responses');
    }
}
