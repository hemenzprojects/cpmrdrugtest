<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrobialEfficacyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbial_efficacy_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('efficacy_analyses_id')->nullable();
            $table->string('pathogen')->nullable()->comment('Same as test conducted');
            $table->string('pi_zone')->nullable()->comment('Product Inhibition Zone');
            $table->string('ci_zone')->nullable()->comment('Ciprofloxacine Inhibition Zone');
            $table->string('fi_zone')->nullable()->comment('Fluconazole Inhibition Zone');
            $table->integer('reference')->nullable()->default(1)->comment('efficacy reference');
            $table->integer('added_by_id')->nullable();
            $table->integer('approved_by_id')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('microbial_efficacy_reports');
    }
}
