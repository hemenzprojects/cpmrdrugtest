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
            $table->integer('compliance')->nullable();
            $table->integer('action')->default(1)->comment('this is to hide/show featuer');
            $table->double('ac_total')->nullable();
            $table->string('definition')->nullable();
            $table->date('date')->nullable()->comment('the date fda introduced new features ');
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
        Schema::dropIfExists('microbial_load_analyses');
    }
}
