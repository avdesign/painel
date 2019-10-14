<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('image_color_id');
            $table->unsignedBigInteger('grid_product_id');
            $table->string('key', 200);
            $table->string('grid', 100);
            $table->tinyInteger('quantity');
            $table->string('image', 200);
            $table->string('color', 50);
            $table->string('code', 50);
            $table->string('profile', 30);
            $table->tinyInteger('offer');
            $table->decimal('percent',8, 2)->nullable();
            $table->decimal('price_card',8, 2)->default(0);
            $table->decimal('price_cash',8, 2)->default(0);
            $table->string('slug', 200);
            $table->smallInteger('kit');
            $table->string('kit_name', 30)->nullable();
            $table->string('name', 50);
            $table->string('category', 50);
            $table->string('section', 50);
            $table->string('brand', 50);
            $table->float('unit');
            $table->string('measure', 30);
            $table->tinyInteger('declare');
            $table->float('weight', 8, 3)->nullable();
            $table->float('width', 8, 3)->nullable();
            $table->float('height', 8, 3)->nullable();
            $table->float('length', 8, 3)->nullable();
            $table->decimal('cost', 8, 2)->nullable();
            $table->text('session');
            $table->string('ip', 50);
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
        Schema::dropIfExists('carts');
    }
}
