<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subject_id');
            $table->integer('user_id')->default(0);
            $table->string('subject', 100);
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('phone', 20)->nullable();
            $table->string('cell', 20)->nullable();
            $table->char('type', 1)->nullable();
            $table->longText('message');
            $table->longText('return')->nullable();
            $table->string('ip', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip_code', 50)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('admin', 30)->nullable();
            $table->string('date_return', 30)->nullable();
            $table->tinyInteger('send')->default(0);
            $table->tinyInteger('client')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('subject_id')->references('id')
                ->on('config_subject_contacts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
