<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('delivery')->default(1);
            $table->integer('invoice')->default(0);
            $table->string('address');
            $table->string('number', 30);
            $table->string('complement')->nullable();
            $table->string('district', 50);
            $table->string('city', 50);
            $table->string('state', 30);
            $table->string('country', 30)->default('BRA');
            $table->string('zip_code', 20);
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
