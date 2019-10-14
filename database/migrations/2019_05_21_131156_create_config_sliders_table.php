<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('config_sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',30);
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
            $table->smallInteger('delay')->nullable();
            $table->string('path');
            $table->smallInteger('width');
            $table->smallInteger('height');
            $table->smallInteger('width_thumb');
            $table->smallInteger('height_thumb');
            $table->smallInteger('width_modal');
            $table->smallInteger('height_modal');
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
        Schema::dropIfExists('config_sliders');
    }
}
