<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigProfileClientsTable extends Migration
{
    /**
     * Configuração do perfil do cliebnte
     * percent_cash  sum +  ou -
     * percent_card  sum +  ou -
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_profile_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('default')->default(0);
            $table->char('order', 2);
            $table->string('name', 50)->unique();
            $table->float('percent_cash');
            $table->float('percent_card');
            $table->enum('sum', ['+', '-']);
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
        Schema::dropIfExists('config_profile_clients');
    }
}
