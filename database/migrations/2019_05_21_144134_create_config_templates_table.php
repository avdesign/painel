<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('config_page_id')->unsigned();
            $table->smallInteger('tmp');
            $table->string('name', 100);
            $table->string('module', 100);
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
            $table->timestamps();

            $table->foreign('config_page_id')
                ->references('id')->on('config_pages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_templates');
    }
}
