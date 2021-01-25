<?php

use Illuminate\Database\Seeder;

class MicrobialEfficacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('microbial_efficacy_analyses')->truncate();
        DB::table('microbial_efficacy_analyses')->insert([
            
            'pathogen'   =>  'S.aureus(ATCC 25923)',
            'pi_zone'   =>  6,
            'ci_zone'   =>  35,
            'fi_zone'   => 'N/A',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('microbial_efficacy_analyses')->insert([
            
            'pathogen'   =>  'E.coli (ATCC 25922)',
            'pi_zone'   =>  6,
            'ci_zone'   =>  35,
            'fi_zone'   =>  'N/A',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('microbial_efficacy_analyses')->insert([
            
            'pathogen'   =>  'C.albicans(ATCC 10231)',
            'pi_zone'   =>  6,
            'ci_zone'   =>  34,
            'fi_zone'   =>  'N/A',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('microbial_efficacy_analyses')->insert([
            
            'pathogen'   =>  'K.pneumoniae (ATCC 33495)',
            'pi_zone'   =>  6,
            'ci_zone'   =>  0,
            'fi_zone'   =>  27,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('microbial_efficacy_analyses')->insert([
            
            'pathogen'   =>  'P.aeruginosa(ATCC 27853)',
            'pi_zone'   =>  6,
            'ci_zone'   =>  25,
            'fi_zone'   =>  'N/A',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('microbial_efficacy_analyses')->insert([
            
            'pathogen'   =>  'P.mirabilis(ATCC 49565)',
            'pi_zone'   =>  6,
            'ci_zone'   =>  30,
            'fi_zone'   =>  'N/A',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('microbial_efficacy_analyses')->insert([
            
            'pathogen'   =>  'S.saprophyticus (ATCC 15305)',
            'pi_zone'   =>  6,
            'ci_zone'   =>  34,
            'fi_zone'   =>  'N/A',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
