<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDeptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_depts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('dept_id');
            $table->integer('status')->default(1)->comment('1 - pending 2 - received 3 - inprogress 4-completed');
            $table->double('quantity');
            $table->string('distributed_by')->nullable();
            $table->string('received_by')->nullable();
            $table->string('delivered_by')->nullable();

            $table->foreign('dept_id')
                ->references('id')->on('depts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('product_depts');
    }
}
