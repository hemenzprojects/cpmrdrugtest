<?php

use Illuminate\Database\Seeder;

class AdminFeatureTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_feature_types')->truncate();

      DB::table('admin_feature_types')->insert(array(
        array('admin_feature_id' => 1, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 2, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 3, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 4, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 5, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 6, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 7, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 8, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 9, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 10, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 11, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 12, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 13, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 14, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 15, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 16, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 17, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 18, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 19, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 20, 'user_type_id' => 1, 'enabled' => 1),
        array('admin_feature_id' => 21, 'user_type_id' => 1, 'enabled' => 1),

    ));
    }
}
