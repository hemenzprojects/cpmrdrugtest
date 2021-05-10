<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Product;
use App\Admin;

use App\SMS\SendSMS;

class ReportSignedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:signed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for notifying when reports are sent to hod';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
           /** Phyto HoD SMS  **/

         $phyto_p =  Product::where('phyto_hod_evaluation',0)->with('departments')->whereHas("departments", function($q){
            return $q->where("dept_id", 3)->where("status", 3);
           })->count();
         $admin = Admin::findOrFail(20);
         if ($phyto_p != 0) {
             SendSMS::sendMessage('Hi '.$admin->full_name.',You have '.$phyto_p.' pending reports to sign. Kindly login to the drug analysis system and complete the process.',$admin->tell);
         }

            /** Micro HoD SMS  **/

          $micro_approval_1 = Product::where('micro_hod_evaluation',0)->where('micro_process_status','<',1)->with('departments')->whereHas("departments", function($q){
            return $q->where("dept_id", 1)->where("status", 3);
          })->count();

          $micro_approval1_admin = Admin::findOrFail(12);
          $system_admin = Admin::findOrFail(2);

          if ($micro_approval_1 != 0) {
            SendSMS::sendMessage('Hi '.$system_admin->full_name.',You have '.$micro_approval_1.' pending reports to sign. Kindly login to the drug analysis system and complete the process.',$system_admin->tell);
            SendSMS::sendMessage('Hi '.$micro_approval1_admin->full_name.',You have '.$micro_approval_1.' pending reports to sign. Kindly login to the drug analysis system and complete the process.',$micro_approval1_admin->tell);
          }

          
          $micro_approval_2 = Product::where('micro_hod_evaluation',2)->where('micro_process_status',1)->with('departments')->whereHas("departments", function($q){
            return $q->where("dept_id", 1)->where("status", 3);
          })->count();
          $micro_approval2_admin = Admin::findOrFail(32);
          if ($micro_approval_2 != 0) {
            SendSMS::sendMessage('Hi '.$micro_approval2_admin->full_name.',You have '.$micro_approval_2.' pending reports to sign. Kindly login to the drug analysis system and complete the process.',$micro_approval2_admin->tell);
          }

            /** Pharm HoD SMS  **/

          $pharm_approval_1 =  Product::where('pharm_hod_evaluation',0)->where('pharm_process_status',5)->with('departments')->whereHas("departments", function($q){
            return $q->where("dept_id", 2)->where("status", 7);
          })->with('animalExperiment')->whereHas("animalExperiment")->count();

          $pharm_approval1_admin = Admin::findOrFail(29);
          $pharm_approval2_admin = Admin::findOrFail(28);
         if ($pharm_approval_1 != 0) {
             SendSMS::sendMessage('Hi '.$pharm_approval1_admin->full_name.',You have '.$pharm_approval_1.' pending reports to sign. Kindly login to the drug analysis system and complete the process.',$pharm_approval1_admin->tell);
             SendSMS::sendMessage('Hi '.$pharm_approval2_admin->full_name.',You have '.$pharm_approval_1.' pending reports to sign. Kindly login to the drug analysis system and complete the process.',$pharm_approval2_admin->tell);
         }
         

         $pharm_approval_3 =  Product::where('pharm_hod_evaluation',2)->where('pharm_process_status',6)->with('departments')->whereHas("departments", function($q){
          return $q->where("dept_id", 2)->where("status", 7);
        })->with('animalExperiment')->whereHas("animalExperiment")->count();


       $pharm_approval3_admin = Admin::findOrFail(35);
       if ($pharm_approval_3 != 0) {
           SendSMS::sendMessage('Hi '.$pharm_approval3_admin->full_name.',You have '.$pharm_approval_3.' pending reports to sign. Kindly login to the drug analysis system and complete the process.',$pharm_approval3_admin->tell);
       }

        $this->info('SMS Sent');

    }
}
