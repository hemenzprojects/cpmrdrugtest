<?php

use Illuminate\Database\Seeder;

class PhytochemicalConstituentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phyto_chemical_constituents')->truncate();
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Saponins',        
            'description'   =>  'Saponins text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Reducing Sugars',        
            'description'   =>  'Reducing Sugar text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Phenolic Compounds',        
            'description'   =>  'Phenolic Compounds text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Polyuronides',        
            'description'   =>  'Polyuronides text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Cyanogenic Glycoside',        
            'description'   =>  'Cyanogenic Glycoside text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Alkaloids',        
            'description'   =>  'Alkaloids text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Triterpenes',        
            'description'   =>  'Triterpenes text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Phytosterols',        
            'description'   =>  'Phytosterols text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Flavanoids',        
            'description'   =>  'Flavanoids text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Anthracenosides',        
            'description'   =>  'Anthracenosides text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Fatty Acids',        
            'description'   =>  'Saponins text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'Sulphur',        
            'description'   =>  'Saponins text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('phyto_chemical_constituents')->insert([
            'name'   =>  'None Detected',        
            'description'   =>  'None Detected text',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")

        ]);
    }
}
