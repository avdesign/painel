<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });



        Schema::create('admin_config_profile', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('config_profile_id');

            $table->foreign('admin_id')->references('id')
                ->on('admins')->onDelete('cascade');

            $table->foreign('config_profile_id')->references('id')
                ->on('config_profiles')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_config_profile');
        Schema::dropIfExists('config_profiles');

    }
}
