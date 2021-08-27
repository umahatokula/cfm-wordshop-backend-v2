<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->float('unit_price', 15, 2);
            $table->float('discount_price', 15, 2);
            $table->integer('quantity_per_unit')->default(1)->nullable();
            $table->integer('units_in_stock')->default(0)->nullable();
            $table->integer('units_on_order')->default(0);
            $table->integer('reorder_level')->nullable();
            $table->boolean('is_taxable')->default(1);
            $table->boolean('is_fulfilled')->default(0);
            $table->boolean('is_available')->default(1);
            $table->boolean('is_discountable')->default(1);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_digital')->default(1);
            $table->boolean('is_audio')->default(1);
            $table->integer('preacher_id')->nullable();
            $table->date('date_preached')->nullable();
            $table->string('size')->default(1)->nullable();
            $table->string('format')->default(1)->nullable();
            $table->string('download_link')->nullable();
            $table->string('s3_key')->nullable();
            $table->string('file_size')->nullable();
            $table->string('large_image_path')->nullable();
            $table->string('thumbnail_image_path')->nullable();
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
        Schema::dropIfExists('products');
    }
}
