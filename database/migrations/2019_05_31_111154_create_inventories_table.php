<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('image_color_id')->nullable();
            $table->bigInteger('grid_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('profile_name', [
                constLang('profile_name.admin'),
                constLang('profile_name.user')
            ]);
            $table->string('type_movement', 100)->nullable();
            $table->text('note')->nullable();
            $table->string('brand', 30);
            $table->string('section', 30);
            $table->string('category', 30);
            $table->string('product', 60);
            $table->string('image')->nullable();
            $table->string('code');
            $table->string('color', 20)->nullable();
            $table->string('grid')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('difference')->default(0);
            $table->decimal('diff_value', 8, 2)->default(0);
            $table->tinyInteger('kit');
            $table->string('kit_name', 30)->nullable();
            $table->tinyInteger('units')->default(0);
            $table->tinyInteger('offer');
            $table->decimal('cost_unit', 8, 2)->default(0);
            $table->decimal('cost_total', 8, 2)->default(0);
            $table->string('price_profile')->nullable();
            $table->decimal('price_unit', 8, 2)->default(0);
            $table->decimal('price_total', 8, 2)->default(0);
            $table->integer('stock')->default(0);
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
        Schema::dropIfExists('inventories');
    }
}
