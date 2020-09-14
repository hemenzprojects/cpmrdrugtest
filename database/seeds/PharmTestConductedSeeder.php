<?php

use Illuminate\Database\Seeder;

class PharmTestConductedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pharm_test_conducteds')->truncate();
        DB::table('pharm_test_conducteds')->insert([
            'name'   =>  'Acute Toxicity Test',        
            'description'   =>  'Test is done by giving medicine through the mouth',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('pharm_test_conducteds')->insert([
            'name'   =>  'Dermal Toxicity Test',        
            'description'   =>  'Test is done by giving medicine through the Skin',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

    }
}
