<?php

namespace App\Http\Controllers\AdminAuth\SID;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\ProductDistributionRequest;
use App\Http\Requests\UpdatecustomerRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\MicrobialLoadReport;
use App\MicrobialEfficacyReport;
use App\Customer;
use App\Department;
use App\ProductType;
use App\Product;
use App\Account;
use App\PharmStandards;
use App\ProductDept;
use \Auth;
use \DB;
use Session;

class SIDController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    //**************************************** */ CUSTOMER SECTION ******************************************

    public function customer_index()
    {

        //   return  $data = \App\Admin::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();
        return View('admin.sid.customers.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function customer_store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'first_name' => 'required|min:3|Alpha',
            'last_name' => 'required|min:3|Alpha',
            'email' => 'required|email|max:128|unique:customers',
            'tell' => 'required|numeric',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required|numeric',
            'company_location' => 'required',
        ]);

        $data = ([
            'title' => $request->title,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tell' => $request->tell,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_location' => $request->company_location,
            'added_by_id' => Auth::guard('admin')->id(),
        ]);
        Customer::create($data);
        Session::flash('message_title', 'success');
        Session::flash('message', 'client successsfully created.');
        return redirect()->route('admin.sid.customer.create')
            ->with('success', 'Customer Created successfully');
    }

    public function customer_edit(Customer $id)
    {

        $data['customers'] = Customer::all();
        $data['c'] = $id;

        return View('admin.sid.customers.update', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function customer_update(UpdatecustomerRequest $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'first_name' => 'required|min:3|Alpha',
            'last_name' => 'required|min:3|Alpha',
            'tell' => 'required|numeric',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required|numeric',
            'company_location' => 'required',
        ]);


        $data = ([
            'title' => $request->title,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tell' => $request->tell,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_location' => $request->company_location,
            'added_by_id' => Auth::guard('admin')->id(),
        ]);

        Customer::where('id', $id)->update($data);
        Session::flash('message_title', 'success');
        Session::flash('message', 'Customer successsfully updated.');
        return redirect()->route('admin.sid.customer.create');
    }
    public function customer_show(Customer $id)
    {
        $data['customer'] = $id;

        return View('admin.sid.customers.show', $data);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function custpmer_destroy(Customer $customer)
    {
        //         


    }

    //**************************************** */ PRODUCT SECTION ******************************************
    public function product_index()
    {
        $data['products'] = Product::orderBy('id', 'DESC')->with("departments")->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();

        return View('admin.sid.products.create', $data);
    }

    public function product_store(StoreProductRequest $request)
    {
        // dd($request);
        $data = ([
            'name' => $request->name,
            'product_type_id' => $request->product_type_id,
            'customer_id' => $request->customer_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'mfg_date' => $request->mfg_date,
            'exp_date' => $request->exp_date,
            'dosage' => $request->dosage,
            'indication' => $request->indication,
            'added_by_id' => Auth::guard('admin')->id(),
        ]);

        Product::create($data);

        Session::flash("message", "Product Successfully Created.");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.product.create')
            ->with('success', 'Product Created successfully');
    }

    public function product_edit(Product $id)
    {

        $data['products'] = Product::orderBy('id', 'DESC')->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();
        $data['p'] = $id;


        return View('admin.sid.products.update', $data);
    }

    public function product_show(Product $id)
    {
        $data['product'] = $id;
        $data['product_history']= Product::where('failed_tag',$id->failed_tag)->whereNotNull('failed_tag')->get();
        
        return view('admin.sid.products.show', $data);
    }

    public function product_update(UpdateProductRequest $request, $id)
    {

        $data = ([
            'name' => $request->name,
            'product_type_id' => $request->product_type_id,
            'customer_id' => $request->customer_id,
            'quantity' => $request->quantity,
            // 'price'=>$request->price,
            'mfg_date' => $request->mfg_date,
            'exp_date' => $request->exp_date,
            'dosage' => $request->dosage,
            'indication' => $request->indication,
            'added_by_id' => Auth::guard('admin')->id(),
        ]);

        Product::where('id', $id)->update($data);
        Session::flash('message_title', 'success');
        Session::flash('message', 'Customer successsfully updated.');
        return redirect()->route('admin.sid.product.create');
    }


    //*********************************************Product Category*****************************************************/


    public function product_type_index()
    {
        $data['product_types'] = ProductType::all();
        $data['pharm_standards'] = PharmStandards::all();

        return View('admin.sid.products.category.index', $data);
    }

    public function product_type_edit(ProductType $id){

        $data['p_type'] = $id;
        $data['product_types'] = ProductType::all();
        $data['pharm_standards'] = PharmStandards::all();

        return View('admin.sid.products.category.edit', $data);

    }

    public function product_category_update(Request $r, ProductType $id){

        $data = $r->validate([
            'code' => 'required', 
            'name' => 'required|min:3|Alpha', 
            'form' => 'required|numeric', 
            'state' => 'required|numeric', 
            'method-applied' => 'required|numeric', 
            'pharm_standard_id' => 'required|numeric', 
        ]);

        Session::flash("message", "Product Category Successfully Created.");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.product.category.edit');

    }


    public function product_category_store(Request $request)
    {

        $data = $request->validate([
            'code' => 'required', 
            'name' => 'required|min:3|Alpha', 
            'form' => 'required|min:3|numeric', 
            'state' => 'required|numeric', 
            'method-applied' => 'required', 
            'pharm_standard_id' => 'required|numeric', 
        ]);

        $data = ([
            'code' => $request->code,
            'name' => $request->name,
            'form' => $request->form,
            'state' => $request->state,
            'method_applied' => $request->method_applied,
            'pharm_standard_id' => $request->pharm_standard_id,
            'description' => $request->description,
            'created_at' => $request->created_at,
            'added_by_id' => Auth::guard('admin')->id(),
        ]);

        ProductType::create($data);

        Session::flash("message", "Product Category Successfully Created.");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.product.category.create')
            ->with('success', 'Product Category Created successfully');
    }

    //********************************************** Account Section ****************************************************** */
    public function account_index($id, $price)
    {

        $product =  product::find($id);
        if (!$product) {
            return redirect()->back();
        }

        $data['product'] = Product::where('id', $id)->with("departments")->first();

        return View('admin.sid.accounts.index', $data);
    }

    public function account_store(Request $r, $id)
    {
        //   dd($r->all(), $id);
        $data = $r->validate([
            'amt_paid' => 'required',
            'customer' => 'required'
        ]);
        if ($r->amt_paid > 460) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Amount should not be more than 460');
            return redirect()->back();
        }
        $product =  product::find($id);
        if (!$product) {
            return redirect()->back();
        }
        $product1 = Product::where('id', $id)->where('price', '=', $r->initial_amt);
        if (count($product1->get()) < 1) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
            return redirect()->back();
        }

        $actualamt = $r->amt_paid + $r->initial_amt;
        if ($actualamt > 460) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Ammount Exceeds actual fee. NB: Product fee is GH 460');
            return redirect()->back();
        }

        if ($product->initial_amt == 1) {
            $data = ([
                'product_id' => $id,
                'customer' => $r->customer,
                'price' => $r->initial_amt,
            ]);
            Account::create($data);
        }

        $data = ([
            'product_id' => $id,
            'customer' => $r->customer,
            'price' => $r->amt_paid,
        ]);
        Account::create($data);



        $data = ([
            'initial_amt' => 2,
            'price' => $actualamt
        ]);
        Product::where('id', $id)->where('price', '=', $r->initial_amt)->update($data);

        return redirect()->route('admin.sid.product.account.index', ['id' => $product->id, 'price' => $product->price]);
    }

    public function account_delete($p_id, $act_id, $price)
    {

        $account = Account::where('id', $act_id)->where('product_id', $p_id)->first();
        if ($account == null) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Sorry there is no product to delete.');
            return redirect()->back();
        }

        Account::where('id', $act_id)->where('product_id', $p_id)->delete();
        $product = Product::where('id', $p_id)->first();
        if ($product->price != $price) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
            return redirect()->back();
        }

        $new_price =  $product->price - $account->price;
        $data = ([
            'price' => $new_price
        ]);
        Product::where('id', $p_id)->where('price', $price)->update($data);

        return redirect()->back();
    }


    //**************************************** */ PRODUCT DISTRIBUTION SECTION ******************************************

    public function distribution_index()
    {
        //     return \App\Product::find(3)->productDept()->where('dept_id',1)->get();
        //    die();

        $data['dept'] = Department::where('dept_type_id', 1)->get();

        $data['products'] = Product::orderBy('id', 'DESC')->doesnthave('departments')->get();

        $data['productdepts'] = Product::orderBy('id', 'DESC')->whereDoesntHave('productDept')->get();



        return View('admin.sid.distribution.create', $data);
    }

    public function distribute_depts_store(ProductDistributionRequest $request)
    {

        $product_id = $request->input('product_id');
        $admin_id = Auth::guard('admin')->id();

        $arrayToInsert = [];

        if ($request->has('microbiology')) {
            $department_1 =  $request->get('microbiology');
            $microquantity = $request->get('microquantity');
            $value = 1;
            if ($department_1 != $value) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
                return redirect()->back();
            }
            if (Product::find( $product_id)->micro_grade ==2){
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! Product passed microbial test. Please check and submit to appropriate department');
                return redirect()->back();
            }
            $temp = [
                'dept_id' => $department_1,
                'product_id' => $product_id,
                'distributed_by' => $admin_id,
                'quantity' => $microquantity,
                'created_at' => now(),
                'updated_at' => now()
            ];
            array_push($arrayToInsert, $temp);
        }

        if ($request->has('pharmacology')) {
            $department_2 =  $request->get('pharmacology');
            $pharmquantity = $request->get('pharmquantity');
            $value = 2;
            if ($department_2 != $value) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
                return redirect()->back();
            }
            if (Product::find( $product_id)->pharm_grade ==2) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! Product passed Pharmacology test. Please check and submit to appropriate department');
                return redirect()->back();
            }
            $temp = [
                'dept_id' => $department_2,
                'product_id' => $product_id,
                'distributed_by' => $admin_id,
                'quantity' => $pharmquantity,
                'created_at' => now(),
                'updated_at' => now()
            ];
            array_push($arrayToInsert, $temp);
        }

        if ($request->has('phytochemistry')) {
            $department_3 =  $request->get('phytochemistry');
            $phytoquantity = $request->get('phytoquantity');
            $value = 3;
            if ($department_3  != $value) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
                return redirect()->back();
            }
            if (Product::find($product_id)->phyto_grade ==2) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! Product passed Phytochemistry test. Please check and submit to appropriate department');
                return redirect()->back();
            }
            $temp = [
                'dept_id' => $department_3,
                'product_id' => $product_id,
                'distributed_by' => $admin_id,
                'quantity' => $phytoquantity,
                'created_at' => now(),
                'updated_at' => now()
            ];
            array_push($arrayToInsert, $temp);
        }

        $inserted = DB::table('product_depts')->insert($arrayToInsert);

        if (Product::where('overall_status', 0)) {
            Product::where('id', $product_id)->update(['overall_status' => 1]);
        }

        Session::flash("message", "Product Successfully Distrituted.");
        Session::flash("message_title", "success");

        return redirect()->route('admin.sid.distribution.create')
            ->with('success', 'Product Created successfully');
    }

    //******************************  Product distribution to single department ***************************** */

    public function distribute_onedept_store(Request $request)
    {
        
        if ($request->product_id == null) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Product field is required. ');
            return redirect()->back();
        }
        Session::flash('activetab', !blank($request->activetab) ? $request->activetab : 0);
        $admin_id = Auth::guard('admin')->id();
        
        // dd($request->all());
         if ($request->dept_id == 1) {
            if (Product::find($request->product_id)->micro_grade==2) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! Product passed Microbial test. Please check and submit to appropriate department');
                return redirect()->back();
            }
            Session::flash('activetab', !blank($request->activetab) ? $request->activetab : 0);
         }
        elseif ($request->dept_id == 2) {
            if (Product::find($request->product_id)->pharm_grade ==2) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! Product passed Pharmacology test. Please check and submit to appropriate department');
                return redirect()->back();
            }Session::flash('activetab', !blank($request->activetab) ? $request->activetab : 0);
         }
        elseif ($request->dept_id == 3) {
            if (Product::find($request->product_id)->phyto_grade ==2) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! Product passed Phytochemical test. Please check and submit to appropriate department');
                return redirect()->back();
            }Session::flash('activetab', !blank($request->activetab) ? $request->activetab : 0);
         }


        $data = ([
            'product_id' => $request->product_id,
            'dept_id' => $request->dept_id,
            'quantity' => $request->microquantity,
            'distributed_by' => $admin_id,
            'created_at' => now(),
            'updated_at' => now()

        ]);

        ProductDept::create($data);

        Session::flash("message", "Product Successfully Distributed.");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.distribution.create')
            ->with('success', 'Product Distributed successfully');
    }




    //**************************************Product Distribution Delete section for all departments  **************************** */

    public  function deleteProduct($id, $dept_id, $activetab = null)
    {

        Session::flash('activetab', !blank($activetab) ? $activetab : 0);

        $product_dept = ProductDept::where('product_id', $id)->where('dept_id', $dept_id)->first();
        if ($product_dept->status == 1) {
            $product_dept->delete();

            $p = Product::find($id)->whereDoesntHave('productDept');
            if ($p) {
                $data = ([
                    'overall_status' => 0
                ]);
                $p->update($data);
            }
            
            Session::flash("message", "Successfully Deleted.");
            Session::flash("message_title", "success");
            return redirect()->route('admin.sid.distribution.create');
        } else {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Sorry! this cant be deleted! Please contact system admin. ');
            return redirect()->back();
        }
    }

    //********************************************************* General Report Section ******************* */
    public function report_index()
    {


        $data['from_date'] = "2020-01-01";
        $data['to_date'] = now();

        $data['product_types'] = \App\ProductType::with(['pending','completed'])->get();

        return View('admin.sid.generalreport.index', $data);
    }


    public function generalyearly_report(Request $r)
    {

        $data = $r->all();
        $data['product_types'] = \App\ProductType::all();

        //  $data['from_date'] =$r->from_date;
        //  $data['to_date'] =$r->from_date;

        $data['pending_reports'] = Product::where('overall_status', 1)->whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ? ', array($data['year']));
        })->get();

        $data['completed_reports'] = Product::where('micro_hod_evaluation', 2)->where("pharm_hod_evaluation", 2)->where('phyto_hod_evaluation', 2)
            ->whereHas("departments", function ($q) use ($data) {
                return $q->whereRaw('YEAR(received_at)= ? ', array($data['year']));
            })->get();

        return view('admin.sid.generalreport.index', $data);
    }

    public function between_months(Request $r)
    {
        // dd($r->all());
        $data = $r->all();
        if ($r->from_date == null) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Please select required date to begin begin');
            return redirect()->route('admin.sid.general_report.index');
        }

        if ($r->to_date == null) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Please select required date to end report');
            return redirect()->route('admin.sid.general_report.index');
        }
        //  $data['from_date'] =$r->from_date;
        //  $data['to_date'] =$r->from_date;

        $data = $r->all();

        $data['product_types'] = \App\ProductType::with(['pending'=>function($query) use ($r){
                $query->whereHas("departments",function ($q) use ($r) {
                            return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                        });
        },
        'completed'=>function($query) use ($r){
            $query->whereHas("departments",function ($q) use ($r) {
                        return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                    });
         }])->get();

                // return $data;
                // die();



        // $data['pending_reports'] = Product::pendingReports($r->from_date, $r->to_date);
        // // return Product::whereHas("departments", function($q)use($r){
        // //     return $q->with("departments")->where("status", '>=', 2)->where('product_depts.created_at', '>=', $r->from_date)->where('product_depts.created_at','<=',$r->to_date);
        // //   })->where('micro_hod_evaluation','<',2)->orWhere("pharm_hod_evaluation",'<',2)->orWhere('phyto_hod_evaluation','<',2)->get();

        // $data['completed_reports'] = Product::where('micro_hod_evaluation', 2)->where("pharm_hod_evaluation", 2)->where('phyto_hod_evaluation', 2)
        //     ->whereHas("departments", function ($q) use ($r) {
        //         return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
        //     })->get();


        return view('admin.sid.generalreport.index', $data);
    }


    public function finalreports_index($id)
    {

        $data['ptype_id'] = $id;
        $data['final_reports'] = Product::where('product_type_id', $id)
            ->where('micro_hod_evaluation', 2)->where("pharm_hod_evaluation", 2)->where('phyto_hod_evaluation', 2)->wherehas('departments')->get();

        return view('admin.sid.generalreport.finalreports', $data);
    }

    public function finalreports_show($id)
    {

        $data['report_id'] = $id;

        $data['micro_withcompletedproducts'] = Product::where('id', $id)->with("departments")->whereHas("departments", function ($q) {
            return $q->where("dept_id", 1)->where("status", '>', 2);
        })->with("loadAnalyses")->orderBy('id', 'DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

        $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id', $id)->orderBy('id', 'ASC')->get();
        $data['check_load'] = MicrobialLoadReport::where('product_id', $id)->orderBy('id', 'ASC')->first();

        $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id', $id)->orderBy('id', 'ASC')->get();


        $data['completed_report'] = Product::where('id', $id)->with('departments')->whereHas("departments", function ($q) {
            return $q->where("dept_id", 2)->where("status", '>', 6);
        })->with('animalExperiment')->whereHas("animalExperiment")->first();


        $data['phytoshowreport'] = Product::where('id', $id)->with('departments')->whereHas("departments", function ($q) {
            return $q->where("dept_id", 3)->where("status", '>', 2);
        })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
            ->with('pchemconstReport')->whereHas('pchemconstReport')->first();

        return view('admin.sid.generalreport.showfinalreport', $data);
    }


    //************************************************************ Home Dashboard *********************************************** */

    public function homedashboard()
    {  

        //************************************ SID */
        $data['year'] = \Carbon\Carbon::now('y');

       $data['all_product'] = Product::whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();
        
        $data['all_pendingproduct'] = Product::where('overall_status','<', 2)    
        ->whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();

        $data['all_completedproduct'] = Product::where('overall_status', 2)
        ->whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();

        $data['all_failedproduct'] = Product::whereNotNull('failed_tag')
        ->whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();

      //****************************************** MICRO */

       $data['micro_products'] = Product::whereHas("departments", function ($q) use ($data) {
        return $q->where("dept_id", 1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();
    
        
      $data['micro_pendingproduct'] = Product::  
      whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 1)->where("status", '<',4);
      })->get();

      $data['micro_completedproduct'] = Product::where('micro_hod_evaluation', 2)    
      ->whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 1)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      
      $data['micro_failedproduct'] = Product::where('micro_grade', 1)    
      ->whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 1)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

        //****************************************** PHARM */

         $data['pharm_products'] = Product::whereHas("departments", function ($q) use ($data) {
            return $q->where("dept_id", 2)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          $data['pharm_pendingproduct'] = Product::whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status", '<',8);
          })->get();

          $data['pharm_completedproduct'] = Product::where('pharm_hod_evaluation', 2)    
          ->whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status", 8)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          $data['pharm_failedproduct'] = Product::where('pharm_grade', 1)    
          ->whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status", 8)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          
      //****************************************** PHYTO */

       $data['phyto_products'] = Product::whereHas("departments", function ($q) use ($data) {
        return $q->where("dept_id", 3)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();
    
        
      $data['phyto_pendingproduct'] = Product::  
      whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 3)->where("status", '<',4);
      })->get();

      $data['phyto_completedproduct'] = Product::where('phyto_hod_evaluation', 2)    
      ->whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 3)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      $data['phyto_failedproduct'] = Product::where('phyto_grade', 1)    
      ->whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 3)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      return view('admin.home', $data);
        
    }

    public function review_product(Product  $product){
     
        $product = $product->last_review_product;
        // return $product->failed_final_grade? "yes": "no";
        if (!$product->failed_final_grade) {
          Session::flash('message_title', 'error');
          Session::flash('message', 'Sorry Product has passed all lab tests and cant be reviewed.');
          return redirect()->back();
        } 
          
        $data['products'] = Product::orderBy('id', 'DESC')->with("departments")->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();

        $data['p'] = $product;

        return View('admin.sid.products.review', $data);

    }

    public function review_create(Request $request, $id){

       $failed_tag = $request->failed_tag;
        $micro_grade =Null;
        $pharm_grade =Null;
        $phyto_grade =Null;
        $micro_hod_evaluation =Null;
        $pharm_hod_evaluation =Null;
        $phyto_hod_evaluation =Null;

       $p = Product::find($id);
       if ($p->failed_tag ) {
          $failed_tag= $p->failed_tag;
       }else{
        $p->update(['failed_tag' => $request->failed_tag]);
       }
       
       if ($p->micro_grade == 2) {
        $micro_grade = 2;
       }
       if ($p->pharm_grade == 2) {
        $pharm_grade = 2;
       }
       if ($p->phyto_grade == 2) {
        $phyto_grade = 2;
       }

       if ($p->micro_grade == 2) {
        $micro_hod_evaluation = 2;
       }
       if ($p->pharm_grade == 2) {
        $pharm_hod_evaluation = 2;
       }
       if ($p->phyto_grade == 2) {
        $phyto_hod_evaluation = 2;
       }
  

       $data = ([
        'name' => $request->name,
        'product_type_id' => $request->product_type_id,
        'customer_id' => $request->customer_id,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'mfg_date' => $request->mfg_date,
        'exp_date' => $request->exp_date,
        'dosage' => $request->dosage,
        'indication' => $request->indication,
        'failed_tag' => $failed_tag,
        'micro_grade' => $micro_grade,
        'pharm_grade' => $pharm_grade,
        'phyto_grade' => $phyto_grade,
        'micro_hod_evaluation' => $micro_hod_evaluation,
        'pharm_hod_evaluation' => $pharm_hod_evaluation,
        'phyto_hod_evaluation' => $phyto_hod_evaluation,
        'added_by_id' => Auth::guard('admin')->id(),

       ]);
  
    Product::create($data);
    Session::flash("message", "Product Successfully Created.");
    Session::flash("message_title", "success");
    return redirect()->route('admin.sid.product.create')
        ->with('success', 'Product Created successfully');
    }

}
