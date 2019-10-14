<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('config_form_payment_id');
            $table->unsignedBigInteger('config_status_payment_id');
            $table->unsignedBigInteger('config_shipping_id');
            $table->string('company', 50)->nullable();
            $table->string('status_label', 50)->nullable();
            $table->smallInteger('qty')->default(0);
            $table->decimal('percent',8, 2)->nullable();
            $table->decimal('price_cash',8, 2)->default(0);
            $table->decimal('price_card',8, 2)->default(0);
            $table->decimal('subtotal',8, 2)->default(0);
            $table->decimal('total',8, 2)->default(0);
            $table->string('coupon')->nullable();
            $table->decimal('discount',8, 2)->default(0);
            $table->decimal('freight',8, 2)->default(0);
            $table->decimal('tax',8, 2)->default(0);
            $table->string('ip', 50);
            $table->string('code', 255);
            $table->string('reference', 255);
            $table->string('token', 255);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('config_form_payment_id')->references('id')
                ->on('config_form_payments')->onDelete('cascade');
            $table->foreign('config_status_payment_id')->references('id')
                ->on('config_status_payments')->onDelete('cascade');
            $table->foreign('config_shipping_id')->references('id')
                ->on('config_shippings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
