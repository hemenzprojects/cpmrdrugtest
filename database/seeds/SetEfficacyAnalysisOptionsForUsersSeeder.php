<?php

use Illuminate\Database\Seeder;
use App\MicrobialEfficacyAnalyses;
use App\Admin;

class SetEfficacyAnalysisOptionsForUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        foreach(Admin::all() as $admin){
        $efficacy_analysis_options = MicrobialEfficacyAnalyses::pluck("id")->toArray();
        $admin->efficacy_analysis_options = json_encode($efficacy_analysis_options);
        $admin->save();
      }
    }
}
