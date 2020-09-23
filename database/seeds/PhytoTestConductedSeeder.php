<?php

use Illuminate\Database\Seeder;

class PhytoTestConductedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phyto_test_conducteds')->truncate();
        DB::table('phyto_test_conducteds')->insert([
            'name'   =>  'Organoleptics',        
            'description'   =>  'Acting on, or involving the use of, the sense organs.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_test_conducteds')->insert([
            'name'   =>  'Physicochemical Data',        
            'description'   =>  'Relating to chemistry that deals with the physicochemical properties of substances.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_test_conducteds')->insert([
            'name'   =>  'Phytochemical Constituents',        
            'description'   =>  'Chemicals produced by plants through primary or secondary metabolism.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

    }
}
