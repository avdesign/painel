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
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->string('brand', 50);
            $table->string('section', 50);
            $table->string('category', 50);
            $table->string('slug', 190)->unique();
            $table->string('tags', 190)->nullable();
            $table->string('video', 190)->nullable();
            $table->float('unit');
            $table->string('measure', 30);
            $table->tinyInteger('declare')->default(0);
            $table->float('weight', 6, 3)->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('length')->nullable();
            $table->string('kit_name', 30)->nullable();
            $table->tinyInteger('kit')->default(0);
            $table->tinyInteger('stock')->default(0);
            $table->tinyInteger('qty_min')->default(1);
            $table->tinyInteger('qty_max')->default(1);
            $table->tinyInteger('freight')->default(0);
            $table->tinyInteger('new')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('offer')->default(0);
            $table->dateTime('offer_date')->nullable();
            $table->tinyInteger('trend')->default(0);
            $table->tinyInteger('black_friday')->default(0);
            $table->tinyInteger('active')->default(0);
            $table->smallInteger('visits')->default(0);
            $table->timestamps();

            $table->foreign('brand_id')->references('id')
                ->on('brands')->onDelete('cascade');
            $table->foreign('section_id')->references('id')
                ->on('sections')->onDelete('cascade');
            $table->foreign('category_id')->references('id')
                ->on('categories')->onDelete('cascade');

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
