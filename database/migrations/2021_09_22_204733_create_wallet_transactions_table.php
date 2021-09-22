<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('wallet_id')->nullable();
            $table->integer('amount')->nullable()->comment('Trnx amount');
            $table->string('type')->nullable()->comment('Trnx type: debit/credit');
            $table->integer('balance')->nullable();
            $table->string('reference')->nullable()->comment('Trnx ref');
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
        Schema::dropIfExists('wallet_transactions');
    }
}
