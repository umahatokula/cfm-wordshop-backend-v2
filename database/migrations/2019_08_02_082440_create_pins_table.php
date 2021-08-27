<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pin');
            $table->double('value', 15, 2);
            $table->double('value_used', 15, 2)->defaualt(0.00);
            $table->boolean('is_printed')->defailt(0);
            $table->boolean('is_exhausted')->defailt(0);
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
        Schema::dropIfExists('pins');
    }
}
