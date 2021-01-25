<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmFinalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharm_final_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('pharm_testconducted_id')->nullable();
            $table->string('pharm_animal_model')->nullable();
            $table->string('num_of_animals')->nullable();
            $table->string('no_death')->nullable();
            $table->text('signs_toxicity')->nullable();
            $table->string('animal_sex')->nullable();
            $table->string('method_of_admin')->nullable();
            $table->string('no_group')->nullable();
            $table->text('formulation')->nullable();
            $table->text('preparation')->nullable();
            $table->string('estimated_dose')->nullable();
            $table->string('no_days')->nullable();
            $table->string('dosage')->nullable();

            $table->integer('added_by_id')->nullable();

            $table->foreign('pharm_testconducted_id')
            ->references('id')->on('pharm_test_conducteds')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('pharm_animal_model')
            ->references('id')->on('pharm_animal_models')
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
        Schema::dropIfExists('pharm_final_reports');
    }
}
