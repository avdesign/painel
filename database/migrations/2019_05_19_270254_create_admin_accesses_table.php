<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAccessesTable extends Migration
{
    /**
     * Controle de acesso dos usuários do sistema
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id');
            $table->string('last_ip', 30)->nullable();
            $table->string('last_url', 100);
            $table->string('last_logout', 30);
            $table->integer('qty_visits');
            $table->nullableTimestamps();

            $table->foreign('admin_id')->references('id')
                ->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_accesses');
    }
}
