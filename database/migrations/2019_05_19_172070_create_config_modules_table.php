<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigModulesTable extends Migration
{
    /**
     * Configura dos Modulos
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['C', 'A', 'R'])->comment('C:congig , A:admin, R:reserved');
            $table->string('name', 50);
            $table->string('label', 100);
            $table->char('order', 2);
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
        Schema::dropIfExists('config_modules');
    }
}
