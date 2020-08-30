<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrobialLoadReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbial_load_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('load_analyses_id')->nullable();
            $table->string('test_conducted')->nullable();
            $table->string('result')->nullable();
            $table->double('rs_total')->nullable();
            $table->string('acceptance_criterion')->nullable();
            $table->double('ac_total')->nullable();
            $table->integer('added_by_id')->nullable();
            $table->integer('approved_by_id')->nullable();

            $table->timestamps();

            $table->foreign('load_analyses_id')
            ->references('id')->on('microbial_load_analyses')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('microbial_load_reports');
    }
}
