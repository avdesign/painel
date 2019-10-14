<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGridProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grid_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('image_color_id');
            $table->string('color', 100);
            $table->smallInteger('kit')->default(0);
            $table->smallInteger('units')->default(0);
            $table->smallInteger('qty_min')->default(0);
            $table->smallInteger('qty_max')->default(0);
            $table->string('grid', 100)->nullable();
            $table->smallInteger('input')->default(0);
            $table->smallInteger('output')->default(0);
            $table->smallInteger('stock')->default(0);

            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade');

            $table->foreign('image_color_id')->references('id')
                ->on('image_colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grid_products');
    }
}
