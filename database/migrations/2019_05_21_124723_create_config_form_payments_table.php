<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigFormPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_form_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method', 20);
            $table->char('order', 2);
            $table->string('label', 50)->unique();
            $table->text('description');
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
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
        Schema::dropIfExists('config_form_payments');
    }
}
