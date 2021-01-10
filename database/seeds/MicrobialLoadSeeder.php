<?php

use Illuminate\Database\Seeder;

class MicrobialLoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('microbial_load_analyses')->truncate();
        DB::table('microbial_load_analyses')->insert([
            
            'test_conducted'   =>  '1 TAMC/ 37 0 C /24hrs/PCA',
            'result'   =>  '8.9 x 10^3',
            'rs_total'   =>  8900,
            'acceptance_criterion'=>  '5.0 X 10^4',
            'ac_total'   =>  50000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

      ]);
 
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  '2 TYMC/ 25 0 C /5Days/MEA',
            'result'   =>  '3.5 x 10^3',
            'rs_total'   =>  3500,
            'acceptance_criterion'=>  '5.0 X 10^2',
            'ac_total'   =>  500,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  'E Coli',
            'result'   =>  'Present',
            'rs_total'   =>  1,
            'acceptance_criterion'=>  'Absent',
            'ac_total'   =>  0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  'Salmonella spp',
            'result'   =>  'Absent',
            'rs_total'   =>  0,
            'acceptance_criterion'=>  'Absence',
            'ac_total'   =>  0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  'Staphylococcus spp',
            'result'   =>  'Absent',
            'rs_total'   =>  0,
            'acceptance_criterion'=>  'Absence',
            'ac_total'   =>  0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
    }
}
