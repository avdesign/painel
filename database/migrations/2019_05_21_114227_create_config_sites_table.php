<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_site', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('header')->default(1);
            $table->smallInteger('menu')->default(1);
            $table->smallInteger('breadcrumbs')->default(1);
            $table->smallInteger('countdown')->default(1);
            $table->smallInteger('social_share')->default(1);
            $table->smallInteger('page_home')->default(1);
            $table->smallInteger('page_products')->default(1);
            $table->smallInteger('page_categories')->default(1);
            $table->smallInteger('page_sections')->default(1);
            $table->smallInteger('page_brands')->default(1);
            $table->smallInteger('limit_products')->default(30);
            $table->smallInteger('list')->default(1);
            $table->smallInteger('detail_products')->default(1);
            $table->smallInteger('tabs_products')->default(1);
            $table->smallInteger('long_description')->default(1);
            $table->smallInteger('comments_products')->default(1);
            $table->smallInteger('tags_products')->default(1);
            $table->smallInteger('related_products')->default(1);
            $table->smallInteger('sidebar_products')->default(1);
            $table->smallInteger('image_colors')->default(1);
            $table->smallInteger('image_positions')->default(1);
            $table->smallInteger('change_images')->default(1);
            $table->string('order_products', 50);
            $table->string('order', 30);
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
        Schema::dropIfExists('config_site');
    }
}
