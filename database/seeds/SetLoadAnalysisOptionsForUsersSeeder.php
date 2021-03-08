<?php

use Illuminate\Database\Seeder;
use App\MicrobialLoadAnalyses;
use App\Admin;

class SetLoadAnalysisOptionsForUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Admin::all() as $admin){
            $load_analysis_options = MicrobialLoadAnalyses::pluck("id")->toArray();
            $admin->load_analysis_options = json_encode($load_analysis_options);
            $admin->save();
        }
    }
}
