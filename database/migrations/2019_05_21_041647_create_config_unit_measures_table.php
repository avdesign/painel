<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigUnitMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_unit_measures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('unit');
            $table->string('name', 30);
            $table->char('order', 2);
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
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
        Schema::dropIfExists('config_unit_measures');
    }
}
