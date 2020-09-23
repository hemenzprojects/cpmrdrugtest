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


  Route::group(['prefix' => 'admin' ], function (){

  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
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

   //products distribution Route
   Route::get('sid/distribution/create','AdminAuth\SID\SIDController@distribution_index')->name('admin.sid.distribution.create');
   Route::post('sid/distribute_depts_product','AdminAuth\SID\SIDController@distribute_depts_store');
  
   Route::get('sid/deleteProduct/{id}/{dept_id}','AdminAuth\SID\SIDController@deleteProduct')->name('admin.sid.distributed_product.delete');
   Route::post('sid/distribute_product','AdminAuth\SID\SIDController@distribute_onedept_store');
   
  
    //***********************************Microbiology Route 

    //**Microbial Report routes */admin/micro/create-test' **/
    Route::get('micro/report/create','AdminAuth\Microbiology\MicroController@report_create')->name('admin.micro.report.create');
    Route::post('/microbiology/report/create_test', 'AdminAuth\Microbiology\MicroController@test_create')->name('admin.micro.report.create_test');
    Route::get('micro/report/show/{id}','AdminAuth\Microbiology\MicroController@report_show')->name('admin.microbial_report.show');
    Route::post('micro/report/update/{id}','AdminAuth\Microbiology\MicroController@report_update');
    Route::get('micro/completedreport/show/{id}','AdminAuth\Microbiology\MicroController@completedreport_show')->name('admin.micro.completedreport.show');
    Route::get('micro/printreport/{id}','AdminAuth\Microbiology\MicroController@printreport')->name('admin.micro.printreport');


   //**Microbiology receive product */
   Route::get('micro/receiveproduct','AdminAuth\Microbiology\MicroController@receiveproduct_index')->name('admin.micro.receiveproduct');
   Route::post('/microbiology/checkuser', 'AdminAuth\Microbiology\MicroController@checkuser')->name('admin.checkuser.microproduct');
   Route::post('/microbiology/acceptproduct', 'AdminAuth\Microbiology\MicroController@acceptproduct')->name('admin.accept.microproduct');
   
   //**Microbiology HOD Office */
   Route::get('micro/hod_office/approval','AdminAuth\Microbiology\MicroController@hodoffice_evaluation')->name('admin.micro.hod_office.approval');
   Route::post('micro/hod_office/evaluate', 'AdminAuth\Microbiology\MicroController@evaluate')->name('admin.micro.hod_office.evaluate');
   Route::get('micro/hod_office/evaluate_one/{id}/{evaluate}', 'AdminAuth\Microbiology\MicroController@evaluate_one')->name('admin.micro.hod_office.evaluate_one');

   //* General Report Section */
   Route::get('micro/general_report/index','AdminAuth\Microbiology\MicroController@generalreport_index')->name('admin.micro.general_report.index');
   Route::get('micro/completed_reports/index/{id}','AdminAuth\Microbiology\MicroController@completedreports_index')->name('admin.micro.completed_reports.index');




   //****************************************************Pharmacology Route 
    
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

      //**Pharmacology Animal Experimentation */
   Route::get('pharm/animalexperimentation/create','AdminAuth\Pharmacology\PharmController@animalexperimentation_create')->name('admin.pharm.animalexperimentation.create');
   Route::post('pharm/animalexperiment/receive','AdminAuth\Pharmacology\PharmController@animalexperimentation_receive')->name('admin.pharm.animalexperiment.receive');
   Route::get('pharm/animalexperiment/reject/{id}','AdminAuth\Pharmacology\PharmController@animalexperimentation_reject')->name('admin.pharm.animalexperiment.reject');

   Route::get('pharm/animalexperimentation/maketest','AdminAuth\Pharmacology\PharmController@maketest')->name('admin.pharm.animalexperimentation.maketest');
   Route::post('pharm/animalexperiment/store','AdminAuth\Pharmacology\PharmController@animalexperiment_store')->name('admin.pharm.animalexperiment.store');
   Route::get('pharm/animalexperiment/delete/{id}','AdminAuth\Pharmacology\PharmController@delete_animaltest')->name('admin.pharm.animalexperimentation.delete');
   Route::post('pharm/animalexperiment/update/{id}','AdminAuth\Pharmacology\PharmController@update_animaltest')->name('admin.pharm.animalexperimentation.update');
   Route::get('pharm/animalexperimentation/recordbook','AdminAuth\Pharmacology\PharmController@animalexperiment_recordbook')->name('admin.pharm.animalexperimentation.recordbook');
   Route::get('pharm/animalexperimentation/fetchtoxicity','AdminAuth\Pharmacology\PharmController@animalexperimentation_fetchtoxicity');

    //**Pharmacology HOD Office */
    Route::get('pharm/hod_office/approval','AdminAuth\Pharmacology\PharmController@hodoffice_evaluation')->name('admin.pharm.hod_office.approval');
    Route::post('pharm/hod_office/evaluate', 'AdminAuth\Pharmacology\PharmController@evaluate')->name('admin.pharm.hod_office.evaluate');
    Route::get('pharm/hod_office/completedreports','AdminAuth\Pharmacology\PharmController@hodoffice_completedreports')->name('admin.pharm.hod_office.completedreports');

    //************************************************Phytochemistry Route 
    
   //********* Phytochemistry receive product */

   Route::get('phyto/receiveproduct','AdminAuth\Phytochemistry\PhytoController@receiveproduct_index')->name('admin.phyto.receiveproduct');
   Route::post('/phytochemistry/checkuser','AdminAuth\Phytochemistry\PhytoController@checkuser')->name('admin.phyto.checkuser');
   Route::post('/phytochemistry/accept/product','AdminAuth\Phytochemistry\PhytoController@acceptproduct')->name('admin.phyto.acceptproduct');

   Route::get('phyto/makereport/index','AdminAuth\Phytochemistry\PhytoController@makereport_index')->name('admin.phyto.makereport.index');
   Route::get('phyto/makereport/show/{id}','AdminAuth\Phytochemistry\PhytoController@makereport_show')->name('admin.phyto.makereport.show');
   Route::post('phyto/makereport/create/','AdminAuth\Phytochemistry\PhytoController@makereport_create')->name('admin.phyto.makereport.create');
   Route::post('phyto/makereport/update/{id}','AdminAuth\Phytochemistry\PhytoController@makereport_update')->name('admin.phyto.makereport.update');
  
   Route::get('phyto/makereport/organoleptics/delete/{id}','AdminAuth\Phytochemistry\PhytoController@organoleptics_delete')->name('admin.phyto.makereport.organoleptics.delete');
   Route::post('phyto/makereport/organoleptics/update','AdminAuth\Phytochemistry\PhytoController@organoleptics_update')->name('admin.phyto.makereport.organoleptics.update');

   Route::get('phyto/makereport/physicochemdata/delete/{id}','AdminAuth\Phytochemistry\PhytoController@physicochemdata_delete')->name('admin.phyto.makereport.physicochemdata.delete');
   Route::post('phyto/makereport/physicochemdata/update','AdminAuth\Phytochemistry\PhytoController@physicochemdata_update')->name('admin.phyto.makereport.physicochemdata.update');

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
