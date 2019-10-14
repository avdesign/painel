<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigColorGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_color_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 7);
            $table->string('name', 20);
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
        Schema::dropIfExists('config_color_groups');
    }
}
