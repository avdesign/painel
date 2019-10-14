<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('permission_id');
            $table->string('name', 50);
            $table->string('label', 100);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')
                ->on('admins')->onDelete('cascade');

            $table->foreign('module_id')->references('id')
                ->on('config_modules')->onDelete('cascade');

            $table->foreign('profile_id')->references('id')
                ->on('config_profiles')->onDelete('cascade');

            $table->foreign('permission_id')->references('id')
                ->on('config_permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permissions');
    }
}
