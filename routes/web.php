<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', function () {
        return view('welcome');
    });


  Route::group(['prefix' => 'admin'], function (){

  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('login', 'AdminAuth\LoginController@login');
  Route::get('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');


  Route::get('/','AdminAuth\AdminController@index');
  Route::get('/profile/create', 'AdminAuth\AdminController@profile_create')->name('admin.profile.create');
  Route::post('/profile/uploadfile', 'AdminAuth\AdminController@update_admin');
  
  Route::get('general/home','AdminAuth\SID\SIDController@homedashboard')->name('admin.general.dashboard');

  Route::group(['middleware'=>['sidept']],function(){

//*******************************************************SID DEPT ******************************************************* */

  //customers Route
 
  Route::get('sid/customer/create','AdminAuth\SID\SIDController@customer_index')->name('admin.sid.customer.create');
  Route::get('sid/customer/{id}/edit','AdminAuth\SID\SIDController@customer_edit')->name('admin.sid.customer.edit');
  Route::get('sid/customer/{id}/show','AdminAuth\SID\SIDController@customer_show')->name('admin.sid.customer.show');
  Route::post('sid/create-customer','AdminAuth\SID\SIDController@customer_store');
  Route::post('sid/customer/update/{id}','AdminAuth\SID\SIDController@customer_update');

   //products Route
   Route::get('sid/product/create','AdminAuth\SID\SIDController@product_index')->name('admin.sid.product.create');
   Route::get('sid/product/{id}/edit','AdminAuth\SID\SIDController@product_edit')->name('admin.sid.product.edit');
   Route::get('sid/product/{id}/show','AdminAuth\SID\SIDController@product_show')->name('admin.sid.product.show');
   Route::post('sid/create_product','AdminAuth\SID\SIDController@product_store');
   Route::post('sid/product/update/{id}','AdminAuth\SID\SIDController@product_update');

   //products review Route
   Route::get('sid/product/review/{product}','AdminAuth\SID\SIDController@review_product')->name('admin.sid.product.review');
   Route::post('sid/product/review/create/{id}','AdminAuth\SID\SIDController@review_create');


   //Product Category

     Route::get('sid/product/category/create','AdminAuth\SID\SIDController@product_type_index')->name('admin.sid.product.category.create');
     Route::post('sid/create_product_category','AdminAuth\SID\SIDController@product_category_store');
     Route::post('sid/update_product_category/{id}','AdminAuth\SID\SIDController@product_category_update');
     Route::get('sid/product/category/edit/{id}','AdminAuth\SID\SIDController@product_type_edit')->name('admin.sid.product.category.edit');

   //Product Account
   Route::get('sid/product/account/{id}/{price}','AdminAuth\SID\SIDController@account_index')->name('admin.sid.product.account.index');
   Route::post('sid/product/account/store/{id}','AdminAuth\SID\SIDController@account_store')->name('admin.sid.product.account.store');
   Route::get('sid/product/account/delete/{p_id}/{act_id}/{price}','AdminAuth\SID\SIDController@account_delete')->name('admin.sid.product.account.delete');



   //products distribution Route
   Route::get('sid/distribution/create','AdminAuth\SID\SIDController@distribution_index')->name('admin.sid.distribution.create');
   Route::post('sid/distribute_depts_product','AdminAuth\SID\SIDController@distribute_depts_store');
  
   Route::get('sid/deleteProduct/{id}/{dept_id}/{activetab?}','AdminAuth\SID\SIDController@deleteProduct')->name('admin.sid.distributed_product.delete');
   Route::post('sid/distribute_product','AdminAuth\SID\SIDController@distribute_onedept_store');

   // Report Section
   Route::get('sid/report/index','AdminAuth\SID\SIDController@report_index')->name('admin.sid.general_report.index');
   Route::post('sid/general_report/yearly','AdminAuth\SID\SIDController@generalyearly_report')->name('sid.generalyearlyreport');
   Route::post('sid/general_report/between_month','AdminAuth\SID\SIDController@between_months')->name('admin.sid.general_report.between_months');
   Route::get('sid/final_reports/index/{id}','AdminAuth\SID\SIDController@finalreports_index')->name('admin.sid.final_reports.index');
   Route::get('sid/final_reports/show/{id}','AdminAuth\SID\SIDController@finalreports_show')->name('admin.sid.final_reports.show');

   //Final Report for 3 labs Section
   Route::get('sid/print_microreport/{id}','AdminAuth\Microbiology\MicroController@printreport')->name('admin.sid.print_microreport');
   Route::get('sid/print_pharmreport/show/{id}','AdminAuth\Pharmacology\PharmController@completedreport_show')->name('admin.sid.print_pharmreport');
   Route::get('sid/print_phytoreport/show/{id}','AdminAuth\Phytochemistry\PhytoController@completedreport_show')->name('admin.sid.print_phytoreport');

  });

   // SID Configurations
   Route::group(['middleware'=>['sidepthod']],function(){

   Route::get('sid/config/admin/create','AdminAuth\AdminController@create_admin')->name('admin.sid.config.user.create');
   
  });

    //************************************************************* Microbiology Route *******************************************************


    Route::group(['middleware'=>['deptone']],function(){

    //**Microbial Report routes */admin/micro/create-test' **/
    Route::get('micro/report/create','AdminAuth\Microbiology\MicroController@report_create')->name('admin.micro.report.create');
    Route::post('/microbiology/report/create_test', 'AdminAuth\Microbiology\MicroController@test_create')->name('admin.micro.report.create_test');
    Route::get('micro/report/show/{id}','AdminAuth\Microbiology\MicroController@report_show')->name('admin.microbial_report.show');
    Route::post('micro/report/update/{id}','AdminAuth\Microbiology\MicroController@report_update');
    Route::get('micro/report/delete/{id}','AdminAuth\Microbiology\MicroController@report_delete')->name('admin.micro.report.delete');
    Route::get('micro/completedreport/show/{id}','AdminAuth\Microbiology\MicroController@completedreport_show')->name('admin.micro.completedreport.show');
    Route::get('micro/printreport/{id}','AdminAuth\Microbiology\MicroController@printreport')->name('admin.micro.printreport');


   //**Microbiology receive product */
   Route::get('micro/receiveproduct','AdminAuth\Microbiology\MicroController@receiveproduct_index')->name('admin.micro.receiveproduct');
   Route::post('/microbiology/checkuser', 'AdminAuth\Microbiology\MicroController@checkuser')->name('admin.checkuser.microproduct');
   Route::post('/microbiology/acceptproduct', 'AdminAuth\Microbiology\MicroController@acceptproduct')->name('admin.accept.microproduct');
   
 
   //* General Report Section */
   Route::get('micro/general_report/index','AdminAuth\Microbiology\MicroController@generalreport_index')->name('admin.micro.general_report.index');
   Route::post('micro/general_report/yearly','AdminAuth\Microbiology\MicroController@generalyearly_report')->name('generalyearlyreport');
   Route::get('micro/completed_reports/index/{id}','AdminAuth\Microbiology\MicroController@completedreports_index')->name('admin.micro.completed_reports.index');
   
   Route::post('micro/general_report/between_month','AdminAuth\Microbiology\MicroController@between_months')->name('admin.micro.general_report.between_months');
   Route::post('micro/yearly','AdminAuth\Microbiology\MicroController@yearly_report')->name('yearly');
   Route::post('micro/montlly','AdminAuth\Microbiology\MicroController@monthly_report')->name('monthly');
   Route::post('micro/daily','AdminAuth\Microbiology\MicroController@daily_report')->name('daily');
  
  });
  
  Route::group(['middleware'=>['deptonehod']],function(){
  //**Microbiology HOD Office */
   
  Route::get('micro/hod_office/approval','AdminAuth\Microbiology\MicroController@hodoffice_evaluation')->name('admin.micro.hod_office.approval');
  Route::post('micro/hod_office/evaluate', 'AdminAuth\Microbiology\MicroController@evaluate')->name('admin.micro.hod_office.evaluate');
  Route::get('micro/hod_office/evaluate_one/{id}/', 'AdminAuth\Microbiology\MicroController@evaluate_one_index');
  // Route::get('micro/hod_office/evaluate_one/{id}/{evaluate}', 'AdminAuth\Microbiology\MicroController@evaluate_one_edit');
  
  //Microbiology Hod Sign to Approve */
  Route::post('/micro/hod_office/checkhodsign', 'AdminAuth\Microbiology\MicroController@checkhodsign')->name('admin.micro.hod_office.checkhodsign');
  Route::post('/micro/hod_office/evaluatereport/{id}/', 'AdminAuth\Microbiology\MicroController@evaluate_one_edit')->name('admin.micro.hod_office.evaluatereport');

  //Microbiology configurations */
  Route::get('micro/hod_office/config','AdminAuth\Microbiology\MicroController@hodoffice_config')->name('admin.micro.hod_office.config');
  Route::post('micro/config/microbialanalysis/create','AdminAuth\Microbiology\MicroController@microbialanalysis_create')->name('admin.micro.config.microbialanalysis.create');
  Route::post('micro/config/microbialanalysis/update','AdminAuth\Microbiology\MicroController@microbialanalysis_update')->name('admin.micro.config.microbialanalysis.update');
  Route::post('micro/config/microbialefficacy/create','AdminAuth\Microbiology\MicroController@microbialefficacy_create')->name('admin.micro.config.microbialefficacy.create');
  Route::post('micro/config/microbialefficacy/update','AdminAuth\Microbiology\MicroController@microbialefficacy_update')->name('admin.micro.config.microbialefficacy.update');

  });



   //****************************************************************************Pharmacology Route ************************************************************** */
    
  Route::group(['middleware'=>['pharmdept']],function(){

   //********* Pharmacology receive product */
   Route::get('pharm/receiveproduct','AdminAuth\Pharmacology\PharmController@receiveproduct_index')->name('admin.pharm.receiveproduct');
   Route::post('/pharmacology/checkuser','AdminAuth\Pharmacology\PharmController@checkuser')->name('admin.pharm.checkuser');
   Route::post('/pharmacology/acceptproduct','AdminAuth\Pharmacology\PharmController@acceptproduct')->name('admin.pharm.acceptproduct');
   Route::get('pharm/report/show/{id}','AdminAuth\Pharmacology\PharmController@report_show')->name('admin.pharm.report.show');
   Route::post('/pharm/report/create/{id}', 'AdminAuth\Pharmacology\PharmController@pharmreport_create')->name('admin.pharm.report.create');
   Route::get('pharm/completedreport/show/{id}','AdminAuth\Pharmacology\PharmController@completedreport_show')->name('admin.pharm.completedreport.show');

      //**Pharmacology samplepreparation */
   Route::get('pharm/samplepreparation/create','AdminAuth\Pharmacology\PharmController@samplepreparation_create')->name('admin.pharm.samplepreparation.create');
   Route::post('pharm/samplepreparation/store','AdminAuth\Pharmacology\PharmController@samplepreparation_store')->name('admin.pharm.samplepreparation.store');
   Route::get('pharm/samplepreparation/delete/{id}','AdminAuth\Pharmacology\PharmController@samplepreparation_delete')->name('admin.pharm.samplepreparation.delete');
   Route::get('pharm/samplepreparation/index','AdminAuth\Pharmacology\PharmController@samplepreparation_index')->name('admin.pharm.samplepreparation.index');
   Route::post('pharm/samplepreparation/report','AdminAuth\Pharmacology\PharmController@samplepreparation_report')->name('admin.pharm.samplepreparation.report');

     //* General Report Section */
     Route::get('pharm/general_report/index','AdminAuth\Pharmacology\PharmController@generalreport_index')->name('admin.pharm.general_report.index');
     Route::get('pharm/completed_reports/index/{id}','AdminAuth\Pharmacology\PharmController@completedreports_index')->name('admin.pharm.completed_reports.index');
     Route::post('pharm/general_report/yearly','AdminAuth\Pharmacology\PharmController@generalyearly_report')->name('admin.pharm.generalyearlyreport');
  
     Route::post('pharm/general_report/between_month','AdminAuth\Pharmacology\PharmController@between_months')->name('admin.pharm.general_report.between_months');
  
     Route::post('pharm/yearly','AdminAuth\Pharmacology\PharmController@yearly_report')->name('yearly');
     Route::post('pharm/montlly','AdminAuth\Pharmacology\PharmController@monthly_report')->name('monthly');
     Route::post('pharm/daily','AdminAuth\Pharmacology\PharmController@daily_report')->name('daily');

  });


   //**Pharmacology Animal Experimentation */

   Route::group(['middleware'=>['pharmdeptanimalexp']],function(){

   Route::get('pharm/animalexperimentation/create','AdminAuth\Pharmacology\PharmController@animalexperimentation_create')->name('admin.pharm.animalexperimentation.create');
   Route::post('pharm/animalexperiment/receive','AdminAuth\Pharmacology\PharmController@animalexperimentation_receive')->name('admin.pharm.animalexperiment.receive');
   Route::get('pharm/animalexperiment/reject/{id}','AdminAuth\Pharmacology\PharmController@animalexperimentation_reject')->name('admin.pharm.animalexperiment.reject');
   Route::post('pharm/animalexperiment_recordbook/report','AdminAuth\Pharmacology\PharmController@animalexperiment_recordbook_report')->name('admin.pharm.animalexperiment_recordbook.report');

   Route::get('pharm/animalexperimentation/maketest','AdminAuth\Pharmacology\PharmController@maketest')->name('admin.pharm.animalexperimentation.maketest');
   Route::post('pharm/animalexperiment/store','AdminAuth\Pharmacology\PharmController@animalexperiment_store')->name('admin.pharm.animalexperiment.store');
   Route::get('pharm/animalexperiment/delete/{id}','AdminAuth\Pharmacology\PharmController@delete_animaltest')->name('admin.pharm.animalexperimentation.delete');
   Route::post('pharm/animalexperiment/update/{id}','AdminAuth\Pharmacology\PharmController@update_animaltest')->name('admin.pharm.animalexperimentation.update');
   Route::get('pharm/animalexperimentation/recordbook','AdminAuth\Pharmacology\PharmController@animalexperiment_recordbook')->name('admin.pharm.animalexperimentation.recordbook');
   Route::get('pharm/animalexperimentation/fetchtoxicity','AdminAuth\Pharmacology\PharmController@animalexperimentation_fetchtoxicity');
   Route::get('pharm/animalexperimentation/fetchtanimal_model','AdminAuth\Pharmacology\PharmController@animalexperimentation_fetchanimalmodel');

   });

  Route::group(['middleware'=>['pharmdepthod']],function(){

   //**Pharmacology HOD Office */
   Route::get('pharm/hod_office/approval','AdminAuth\Pharmacology\PharmController@hodoffice_evaluation')->name('admin.pharm.hod_office.approval');
   Route::post('pharm/hod_office/evaluate', 'AdminAuth\Pharmacology\PharmController@evaluate')->name('admin.pharm.hod_office.evaluate');
   Route::get('pharm/hod_office/completedreports','AdminAuth\Pharmacology\PharmController@hodoffice_completedreports')->name('admin.pharm.hod_office.completedreports');
   Route::get('pharm/hod_office/evaluate_one/{id}/', 'AdminAuth\Pharmacology\PharmController@evaluate_one_index');

   Route::get('pharm/report/hod_office/complete_report/{id}','AdminAuth\Pharmacology\PharmController@hod_complete_report')->name('admin.pharm.hod_office.complete_report');

    //Pharmacology Hod Sign to Approve */
    Route::post('/pharm/hod_office/checkhodsign', 'AdminAuth\Pharmacology\PharmController@checkhodsign')->name('admin.pharm.hod_office.checkhodsign');
    Route::post('/pharm/hod_office/evaluatereport/{id}/', 'AdminAuth\Pharmacology\PharmController@evaluate_one_edit')->name('admin.pharm.hod_office.evaluatereport');

    });

   //*********************************************************Phytochemistry Route ****************************************************************************
   
  Route::group(['middleware'=>['phytodept']],function(){

   //********* Phytochemistry receive product */

   Route::get('phyto/receiveproduct','AdminAuth\Phytochemistry\PhytoController@receiveproduct_index')->name('admin.phyto.receiveproduct');
   Route::post('/phytochemistry/checkuser','AdminAuth\Phytochemistry\PhytoController@checkuser')->name('admin.phyto.checkuser');
   Route::post('/phytochemistry/accept/product','AdminAuth\Phytochemistry\PhytoController@acceptproduct')->name('admin.phyto.acceptproduct');
   Route::get('phyto/completedreport/show/{id}','AdminAuth\Phytochemistry\PhytoController@completedreport_show')->name('admin.pharm.completedreport.show');

   Route::get('phyto/makereport/index','AdminAuth\Phytochemistry\PhytoController@makereport_index')->name('admin.phyto.makereport.index');
   Route::get('phyto/makereport/show/{id}','AdminAuth\Phytochemistry\PhytoController@makereport_show')->name('admin.phyto.makereport.show');
   Route::post('phyto/makereport/create/','AdminAuth\Phytochemistry\PhytoController@makereport_create')->name('admin.phyto.makereport.create');
   Route::post('phyto/makereport/update/{id}','AdminAuth\Phytochemistry\PhytoController@makereport_update')->name('admin.phyto.makereport.update');
  
   Route::get('phyto/makereport/organoleptics/delete/{p_id}/{organo_id}','AdminAuth\Phytochemistry\PhytoController@organoleptics_delete')->name('admin.phyto.makereport.organoleptics.delete');
   Route::post('phyto/makereport/organoleptics/update','AdminAuth\Phytochemistry\PhytoController@organoleptics_update')->name('admin.phyto.makereport.organoleptics.update');

   Route::get('phyto/makereport/physicochemdata/delete/{p_id}/{physico_id}','AdminAuth\Phytochemistry\PhytoController@physicochemdata_delete')->name('admin.phyto.makereport.physicochemdata.delete');
   Route::post('phyto/makereport/physicochemdata/update','AdminAuth\Phytochemistry\PhytoController@physicochemdata_update')->name('admin.phyto.makereport.physicochemdata.update');

    //* General Report Section */

   Route::get('phyto/general_report/index','AdminAuth\Phytochemistry\PhytoController@generalreport_index')->name('admin.phyto.general_report.index');
   Route::get('phyto/completed_reports/index/{id}','AdminAuth\Phytochemistry\PhytoController@completedreports_index')->name('admin.phyto.completed_reports.index');
   Route::post('phyto/general_report/between_months','AdminAuth\Phytochemistry\PhytoController@between_months')->name('admin.phyto.general_report.between_months');

 });

   Route::group(['middleware'=>['phytodepthod']],function(){

    //********* PhytochemistryHod HOD Office */
  
    Route::get('phyto/hod_office/approval','AdminAuth\Phytochemistry\PhytoController@hodoffice_evaluation')->name('admin.phyto.hod_office.approval');
    Route::get('phyto/hod_office/evaluate_one/{id}/', 'AdminAuth\Phytochemistry\PhytoController@evaluate_one_index');
    Route::post('phyto/hod_office/evaluate', 'AdminAuth\Phytochemistry\PhytoController@evaluate')->name('admin.phyto.hod_office.evaluate');

    
     //Phytochemistry Hod Sign to Approve */
     Route::post('/phyto/hod_office/checkhodsign', 'AdminAuth\Phytochemistry\PhytoController@checkhodsign')->name('admin.phyto.hod_office.checkhodsign');
     Route::post('/phyto/hod_office/evaluatereport/{id}/', 'AdminAuth\Phytochemistry\PhytoController@evaluate_one_edit')->name('admin.phyto.hod_office.evaluatereport');
 
     //Phytochemistry configurations */
     Route::get('phyto/hod_office/config','AdminAuth\Phytochemistry\PhytoController@hodoffice_config')->name('admin.phyto.hod_office.config');
     Route::post('phyto/config/organoleptics/create','AdminAuth\Phytochemistry\PhytoController@config_organoleptics_create')->name('admin.phyto.config.organoleptics.create');
     Route::post('phyto/config/organoleptics/update','AdminAuth\Phytochemistry\PhytoController@config_organoleptics_update')->name('admin.phyto.config.organoleptics.update');

    });

});




Route::group(['prefix' => 'customer'], function () {
  Route::get('/login', 'CustomerAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'CustomerAuth\LoginController@login');
  Route::get('/logout', 'CustomerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'CustomerAuth\RegisterController@register');

  Route::post('/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'CustomerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');
});
