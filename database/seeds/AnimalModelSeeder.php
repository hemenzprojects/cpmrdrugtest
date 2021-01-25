<?php

use Illuminate\Database\Seeder;

class AnimalModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pharm_animal_models')->truncate();
        DB::table('pharm_animal_models')->insert([
            'name'   =>  'SRD RAT',        
            'description'   =>  'Text of animal model',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_animal_models')->insert([
            'name'   =>  'Wistar Rat',        
            'description'   =>  'Text of animal model',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_animal_models')->insert([
            'name'   =>  'ICR Mice',        
            'description'   =>  'Text of animal model',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_animal_models')->insert([
            'name'   =>  'C57 Mice',        
            'description'   =>  'Text of animal model',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);


    }
}
