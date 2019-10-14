<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSubjectContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_subject_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label', 50);
            $table->longText('message');
            $table->tinyInteger('order');
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
            $table->tinyInteger('send_guest')->default(1);
            $table->tinyInteger('send_user')->default(1);
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
        Schema::dropIfExists('config_subject_contacts');
    }
}
