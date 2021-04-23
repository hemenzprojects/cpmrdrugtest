<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroReportConclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_report_conclusions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('default_conclusion');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('micro_report_conclusions');
    }
}
