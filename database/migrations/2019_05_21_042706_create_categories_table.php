<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('section_id');
            $table->string('name', 50);
            $table->string('section', 50);
            $table->text('description')->nullable();
            $table->string('slug', 150)->unique();
            $table->string('tags', 255);
            $table->integer('visits');
            $table->char('order', 5);
            $table->enum('active', [constLang('active_true'), constLang('active_false')]);
            $table->enum('active_featured', [constLang('active_true'), constLang('active_false')])->default(constLang('active_false'));
            $table->enum('active_banner', [constLang('active_true'), constLang('active_false')])->default(constLang('active_false'));
            $table->timestamps();

            $table->foreign('section_id')->references('id')
                ->on('sections')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
