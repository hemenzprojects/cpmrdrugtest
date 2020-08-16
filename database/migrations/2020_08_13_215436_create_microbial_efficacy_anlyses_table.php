<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrobialEfficacyAnlysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbial_efficacy_analyses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pathogen')->nullable()->comment('Same as test conducted');
            $table->double('pi_zone')->nullable()->comment('Product Inhibition Zone');
            $table->double('ci_zone')->nullable()->comment('Ciprofloxacine Inhibition Zone');
            $table->double('fi_zone')->nullable()->comment('Fluconazole Inhibition Zone');


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
        Schema::dropIfExists('microbial_efficacy_analyses');
    }
}
