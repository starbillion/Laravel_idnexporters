<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('salutation', ['mr', 'mrs', 'ms', 'dr', 'prof'])->nullable();
            $table->string('name');
            $table->string('company')->nullable();
            $table->json('business_types')->nullable();
            $table->string('established')->nullable();
            $table->string('city')->nullable();
            $table->string('postal')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('fax')->nullable();
            $table->string('company_email')->nullable();
            $table->string('website')->nullable();
            $table->boolean('hide_contact')->default(1);
            $table->mediumText('address')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('additional_notes')->nullable();
            $table->boolean('halal')->default(0);
            $table->string('main_exports')->nullable();
            $table->string('main_imports')->nullable();
            $table->string('export_destinations')->nullable();
            $table->string('current_markets')->nullable();
            $table->string('annual_revenue')->nullable();
            $table->string('product_interests')->nullable();
            $table->json('languages')->nullable();
            $table->json('categories')->nullable();
            $table->mediumText('factory_address')->nullable();
            $table->mediumText('certifications')->nullable();
            $table->string('video_1')->nullable();
            $table->string('video_2')->nullable();
            $table->string('video_3')->nullable();
            $table->boolean('subscribe')->default(1);
            $table->integer('balance')->default(0);
            $table->boolean('active')->default(1);
            $table->boolean('verified_member')->default(0);
            $table->smallInteger('status')->default(0);
            $table->dateTime('moderated_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
