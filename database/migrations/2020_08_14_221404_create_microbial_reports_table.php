<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrobialReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbial_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('load_analyses_id')->nullable();
            $table->string('test_conducted')->nullable();
            $table->string('result')->nullable();
            $table->double('rs_total')->nullable();
            $table->string('acceptance_criterion')->nullable();
            $table->double('ac_total')->nullable();
            $table->integer('efficacy_analyses_id')->nullable();
            $table->string('pathogen')->nullable()->comment('Same as test conducted');
            $table->double('pi_zone')->nullable()->comment('Product Inhibition Zone');
            $table->double('ci_zone')->nullable()->comment('Ciprofloxacine Inhibition Zone');
            $table->double('fi_zone')->nullable()->comment('Fluconazole Inhibition Zone');
            $table->integer('added_by_id')->nullable();

            $table->timestamps();

            $table->foreign('load_analyses_id')
            ->references('id')->on('microbial_load_analyses')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('efficacy_analyses_id')
            ->references('id')->on('microbial_efficacy_analyses')
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
        Schema::dropIfExists('microbial_reports');
    }
}
