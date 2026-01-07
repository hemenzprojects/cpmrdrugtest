<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_key')->unique();
            $table->string('feature')->default('evaluate_report'); // Feature name
            $table->boolean('is_active')->default(false);
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('api_response')->nullable(); // Store last API response
            $table->string('api_url')->nullable();
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
        Schema::dropIfExists('licenses');
    }
}
