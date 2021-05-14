<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->double('alllabs_price');
            $table->double('singlelab_price');
            $table->double('mutilabs_price');
            $table->integer('action')->default(0)->comment('this is to hide/activate price list');
            $table->integer('updated_by_id')->nullable();
            $table->integer('added_by_id')->nullable();
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
        Schema::dropIfExists('product_price_lists');
    }
}
