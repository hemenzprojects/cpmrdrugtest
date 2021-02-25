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
            'result'   =>  '0.0 x 10^0',
            'rs_total'   =>  8900,
            'acceptance_criterion'=>  '5.0 X 10^4',
            'ac_total'   =>  50000,
            'definition'   =>  '1 TAMC = Total Aerobic Microbial Count',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

      ]);
 
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  '2 TYMC/ 25 0 C /5Days/MEA',
            'result'   =>  '0.0 x 10^0',
            'rs_total'   =>  3500,
            'acceptance_criterion'=>  '5.0 X 10^2',
            'ac_total'   =>  500,
            'definition'   =>  '2 TYMC = Total Yeast and Molds Counts',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  'E Coli',
            'result'   =>  'None',
            'rs_total'   =>  0,
            'acceptance_criterion'=>  'Absent',
            'ac_total'   =>  0,
            'definition'   =>  Null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  'Salmonella spp',
            'result'   =>  'None',
            'rs_total'   =>  0,
            'acceptance_criterion'=>  'Absence',
            'ac_total'   =>  0,
            'definition'   =>  Null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('microbial_load_analyses')->insert([
                    
            'test_conducted'   =>  'Staphylococcus spp',
            'result'   =>  'None',
            'rs_total'   =>  0,
            'acceptance_criterion'=>  'Absence',
            'ac_total'   =>  0,
            'definition'   =>  Null,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
    }
}
