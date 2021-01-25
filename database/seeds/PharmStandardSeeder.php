<?php

use Illuminate\Database\Seeder;

class PharmStandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pharm_standards')->truncate();
        DB::table('pharm_standards')->insert([
            'name'   =>  'None',
            'description'   =>  'None',
            'default'   =>  'None',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('pharm_standards')->insert([
            'name'   =>  'standard 1',
            'description'   =>  'For creams',
            'default'   =>  'An area of hair on the lateral portion of the albino rats (about 9 cm2) was trimmed and shaved with a razor blade. The rats were divided into 3 groups (n=5). Group one was injected intradermally with 0.1 ml of 1% w/v of the cream dissolved in glycerol, group two with 0.1 ml of 5% w/v of the cream dissolved in glycerol and group three as control was treated with only 0.1 ml glycerol. The cream was also applied topically (0.5-1.0 g) to the shaved area of the first two groups of rats and the animals were observed for a period of 48 hours for any signs of ulceration, irritation and/or inflammation as compared to the control groups.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('pharm_standards')->insert([
            'name'   =>  'standard 2',
            'description'   =>  'For balms',
            'default'   =>  'An area of hair on the lateral portion of the albino rats (about 9 cm2) was trimmed and shaved with a razor blade. The rats were divided into 3 groups (n=5). Group one was injected intradermally with 0.1 ml of 1% w/v of the balm dissolved in glycerol, group two with 0.1 ml of 5% w/v of the balm dissolved in glycerol and group three as control was treated with only 0.1 ml glycerol. The balm was also applied topically (0.5-1.0 g) to the shaved area of the first two groups of rats and the animals were observed for a period of 48 hours for any signs of ulceration, irritation and/or inflammation as compared to the control groups.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
 
        DB::table('pharm_standards')->insert([
            'name'   =>  'standard 3',
            'description'   =>  'For ointments',
            'default'   =>  'An area of hair on the lateral portion of the albino rats (about 9 cm2) was trimmed and shaved with a razor blade. The rats were divided into 3 groups (n=5). Group one was injected intradermally with 0.1 ml of 1% w/v of the ointment dissolved in glycerol, group two with 0.1 ml of 5% w/v of the ointment dissolved in glycerol and group three as control was treated with only 0.1 ml glycerol. The ointment was also applied topically (0.5-1.0 g) to the shaved area of the first two groups of rats and the animals were observed for a period of 48 hours for any signs of ulceration, irritation and/or inflammation as compared to the control groups.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
 
        DB::table('pharm_standards')->insert([
            'name'   =>  'standard 4',
            'description'   =>  'For liquid soap',
            'default'   =>  'A 10 ml of the product (Hair conditioner) was used to prepare a 1 % and 5 % w/v solution of the hair conditioner in glycerol. Fifteen Sprague Dawley rats were grouped into 3 (n=5). An area of hair on the lateral portion of the rats (about 9 cm2) was trimmed and shaved with a razor blade. Group one was injected intradermally with 0.1 ml of the 1 % hair conditioner in glycerol solution and group two with 0.1 ml of 5 % w/v of the hair conditioner in glycerol. Group three served as the control and was injected intradermally with only 0.1 ml glycerol. The hair conditioner was also applied topically (0.5-1.0 g) to the shaved area of the first two groups while glycerol was applied to the control group. The animals were observed for a period of 48 hours for any signs of ulceration, irritation and/or inflammation as compared to the control groups.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('pharm_standards')->insert([
            'name'   =>  'standard 5',
            'description'   =>  'For Solid soap',
            'default'   =>  'A 10 ml of the product (Hair conditioner) was used to prepare a 1 % and 5 % w/v solution of the hair conditioner in glycerol. Fifteen Sprague Dawley rats were grouped into 3 (n=5). An area of hair on the lateral portion of the rats (about 9 cm2) was trimmed and shaved with a razor blade. Group one was injected intradermally with 0.1 ml of the 1 % hair conditioner in glycerol solution and group two with 0.1 ml of 5 % w/v of the hair conditioner in glycerol. Group three served as the control and was injected intradermally with only 0.1 ml glycerol. The hair conditioner was also applied topically (0.5-1.0 g) to the shaved area of the first two groups while glycerol was applied to the control group. The animals were observed for a period of 48 hours for any signs of ulceration, irritation and/or inflammation as compared to the control groups.',
            'added_by_id'   =>  1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
