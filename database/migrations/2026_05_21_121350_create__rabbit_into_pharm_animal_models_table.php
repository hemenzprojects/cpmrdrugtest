<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRabbitIntoPharmAnimalModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('pharm_animal_models')->insert([
            'name' => 'Rabbit',
            'description' => 'Text of animal model',
            'added_by_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('pharm_animal_models')
            ->where('name', 'Rabbit')
            ->where('added_by_id', 1)
            ->delete();
    }
}