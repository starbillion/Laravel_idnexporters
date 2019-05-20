<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->string('venue')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('ending_at')->nullable();
            $table->string('organizer')->nullable();
            $table->string('edition')->nullable();
            $table->mediumText('body')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('calendar')->default(0);
            $table->string('color')->default('#91c2f7');
            $table->boolean('directory')->default(0);
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::create('exhibition_exhibitors', function (Blueprint $table) {
            $table->integer('exhibition_id')->unsigned();
            $table->integer('exhibitor_id')->unsigned();
            $table->string('booth')->nullable();

            $table->foreign('exhibition_id')->references('id')->on('exhibitions');
            $table->foreign('exhibitor_id')->references('id')->on('exhibitors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exhibition_exhibitors');
        Schema::dropIfExists('exhibitions');
    }
}
