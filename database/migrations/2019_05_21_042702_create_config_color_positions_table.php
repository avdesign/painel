<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigColorPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_color_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('type', 1);
            $table->string('path', 50);
            $table->smallInteger('width');
            $table->smallInteger('height');
            $table->char('default', 1);
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
        Schema::dropIfExists('config_color_positions');
    }
}
