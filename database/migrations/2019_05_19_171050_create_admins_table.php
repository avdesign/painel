<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('login', 30)->unique();
            $table->string('profile', 30);
            $table->string('phone', 20);
            $table->string('email', 50)->unique();
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
            $table->enum('commission', [constLang('yes'), constLang('not')]);
            $table->float('percent')->default(0);
            $table->string('password');
            $table->string('image','100')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
