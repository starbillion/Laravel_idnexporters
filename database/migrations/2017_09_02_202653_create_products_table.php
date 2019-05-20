<?php

use Kalnoy\Nestedset\NestedSet;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            NestedSet::columns($table);
            $table->timestamps();
            $table->string('old_id')->nullable();
            $table->softDeletes();
        });

        Schema::create('product_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('currency_id')->nullable()->unsigned();
            $table->string('name');
            $table->mediumText('description_en')->nullable();
            $table->mediumText('description_id')->nullable();
            $table->mediumText('description_zh')->nullable();
            $table->string('supply_ability')->nullable();
            $table->string('fob_port')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('minimum_order')->nullable();
            $table->string('price')->nullable();
            $table->boolean('publish')->default(1);
            $table->boolean('active')->default(1);
            $table->smallInteger('status')->default(0);
            $table->integer('moderated_by')->nullable()->unsigned();
            $table->dateTime('moderated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('moderated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_posts');
    }
}
