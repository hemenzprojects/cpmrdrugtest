<?php

use Illuminate\Database\Seeder;

class PhytoOrganolepticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phyto_organoleptics')->truncate();
        DB::table('phyto_organoleptics')->insert([
            'name'   =>  'Dosage Form',        
            'feature'   =>  'Powder',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_organoleptics')->insert([
            'name'   =>  'Colour (Content)',        
            'feature'   =>  'Brown',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_organoleptics')->insert([
            'name'   =>  'Colour (Shell)',        
            'feature'   =>  'shell',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        
        DB::table('phyto_organoleptics')->insert([
            'name'   =>  'Odour',        
            'feature'   =>  'shell',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_organoleptics')->insert([
            'name'   =>  'Clarity',        
            'feature'   =>  'Slightly Cloudy',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_organoleptics')->insert([
            'name'   =>  'Appearancr/ Texture',        
            'feature'   =>  'Slightly Cloudy',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
    }
}
