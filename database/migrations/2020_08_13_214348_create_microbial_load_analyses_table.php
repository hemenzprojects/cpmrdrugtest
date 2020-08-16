<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrobialLoadAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbial_load_analyses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('test_conducted')->nullable();
            $table->string('result')->nullable();
            $table->double('rs_total')->nullable();
            $table->string('acceptance_criterion')->nullable();
            $table->double('ac_total')->nullable();
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
        Schema::dropIfExists('microbial_load_analyses');
    }
}
