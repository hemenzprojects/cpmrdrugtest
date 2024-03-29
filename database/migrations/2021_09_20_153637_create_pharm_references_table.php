<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharm_references', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32)->nullable();
            $table->integer('action')->nullable();
            $table->text('reference')->nullable();
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
        Schema::dropIfExists('pharm_references');
    }
}
