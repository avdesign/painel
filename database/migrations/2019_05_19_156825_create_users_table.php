<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedInteger('type_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 50)->unique();
            $table->string('document1', 50);
            $table->string('document2', 50);
            $table->string('phone', 30)->nullable();
            $table->string('cell', 30);
            $table->string('admin', 30)->nullable();
            $table->string('token')->nullable();
            $table->string('password');
            $table->string('date', 10);
            $table->tinyInteger('client')->default(0);
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
            $table->tinyInteger('newsletter')->default(0);
            $table->integer('visits')->default(0);
            $table->string('ip', 30);
            $table->dateTime('last_login')->nullable();
            $table->dateTime('logout')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('profile_id')->references('id')
                ->on('config_profile_clients');

            $table->foreign('type_id')->references('id')
                ->on('account_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
