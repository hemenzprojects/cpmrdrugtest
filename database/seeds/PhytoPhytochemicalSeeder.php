<?php

use Illuminate\Database\Seeder;

class PhytoPhytochemicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phyto_physicochem_data')->truncate();
        DB::table('phyto_physicochem_data')->insert([
            'name'   =>  'Total Water Extration',        
            'result'   =>  '1.0 +/- 4.87% w/ew',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_physicochem_data')->insert([
            'name'   =>  'Total Solid Residue',        
            'result'   =>  '1.61 +/- 0.00% w/v',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        
        DB::table('phyto_physicochem_data')->insert([
            'name'   =>  'Specific Gravity',        
            'result'   =>  '1.0160',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_physicochem_data')->insert([
            'name'   =>  'pH (1% aqueous extract)',        
            'result'   =>  '2.87@25.9 0^C',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

     
        DB::table('phyto_physicochem_data')->insert([
            'name'   =>  'Volume of Product',        
            'result'   =>  '1.0 +/- 0.00 ml',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_physicochem_data')->insert([
            'name'   =>  'Net Weight of Product',        
            'result'   =>  '143.84 +/- 2.35 g',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

    }
}
