<?php

use Illuminate\Database\Seeder;

class PharmToxicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pharm_toxicities')->truncate();

       DB::table('pharm_toxicities')->insert([
            'name'   =>  'No Sign',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
       DB::table('pharm_toxicities')->insert([
            'name'   =>  'Hyperactivity',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   =>  'Hyperreactivity',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   =>  'Ruffledfur',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   =>  'Gaitabnormality',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   =>  'Spasms in legs',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   => 'Exessive Grooming',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   =>'Lack of Grooming',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]); 
        
        DB::table('pharm_toxicities')->insert([
            'name'   => 'Onions',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   => 'Issolation',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   => 'Salivation',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('pharm_toxicities')->insert([
            'name'   => 'Salivation',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]); 
        
        DB::table('pharm_toxicities')->insert([
            'name'  => 'Decreased Locomotor',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]); 
        
        DB::table('pharm_toxicities')->insert([
            'name'  =>  'Increased Locomotor',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('pharm_toxicities')->insert([
            'name'   =>  'Nill',        
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
