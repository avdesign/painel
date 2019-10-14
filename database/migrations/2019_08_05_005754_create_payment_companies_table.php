<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',30)->nullable();
            $table->string('slug',30)->nullable();
            $table->smallInteger('billet')->default(0);
            $table->smallInteger('cash')->default(0);
            $table->smallInteger('credit')->default(0);
            $table->smallInteger('debit')->default(0);
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
        Schema::dropIfExists('payment_companies');
    }
}
