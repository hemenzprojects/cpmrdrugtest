<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminFeatureTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_feature_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_feature_id')->unsigned()->index();
            $table->integer('user_type_id')->unsigned()->index();
            $table->boolean('enabled')->default(0);

            $table->foreign('admin_feature_id')
            ->references('id')->on('admin_features')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('user_type_id')
            ->references('id')->on('user_types')
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
        Schema::dropIfExists('admin_feature_types');
    }
}
