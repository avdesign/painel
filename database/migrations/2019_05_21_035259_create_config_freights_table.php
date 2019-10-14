<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_freights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('default');
            $table->smallInteger('distribute_box');
            $table->smallInteger('weight');
            $table->smallInteger('width');
            $table->smallInteger('height');
            $table->smallInteger('length');
            $table->smallInteger('declare');
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
        Schema::dropIfExists('config_freights');
    }
}
