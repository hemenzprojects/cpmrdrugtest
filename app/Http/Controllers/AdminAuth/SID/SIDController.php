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
use App\MicrobialEfficacyAnalyses;
use App\MicrobialLoadAnalyses;
use App\PhytoPhysicochemData;
use App\PhytoOrganoleptics;
use App\PhytoChemicalConstituents;
use App\PhytoChemicalConstituentsReport;
use App\Admin;
use App\Customer;
use App\Department;
use App\ProductType;
use App\ProductPriceList;
use App\Product;
use App\Account;
use App\UserType;
use App\PharmStandards;
use App\ProductDept;
use App\SmsNotification;
use \Auth;
use \DB;
use Session;
use App\SMS\SendSMS;
use App\SMS\SendbulkSMS;


class SIDController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    //**************************************** */ CUSTOMER SECTION ******************************************

    public function customer_index()
    {    

        
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(1)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
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
     
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(2)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        
        $customer = Customer::where('email',$request->email)->get();
        if (count($customer) >0) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Sorry! this record cant be edited. In report process mode');
        }
        
        $data = $request->validate([
            'title' => 'required',
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email|max:128|unique:customers',
            'tell' => 'required|numeric',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required|numeric',
            'company_location' => 'required',
        ]);

        $data = ([
            'title' => $request->title,
            'code' => $request->code,
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
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(1)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

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
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(2)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        $data = $request->validate([
            'title' => 'required',
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'tell' => 'required|numeric',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required|numeric',
            'company_location' => 'required',
        ]);


        $data = ([
            'title' => $request->title,
            'code' => $request->code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tell' => $request->tell,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_location' => $request->company_location,
            'updated_by_id' => Auth::guard('admin')->id(),
        ]);

        Customer::where('id', $id)->update($data);
        Session::flash('message_title', 'success');
        Session::flash('message', 'Customer successsfully updated.');
        return redirect()->route('admin.sid.customer.create');
    }
    public function customer_show(Customer $id)
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(1)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
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

    Public function sendsms_index(){
       
        $data['year'] = \Carbon\Carbon::now()->year;
        $data['customer_completed_report_1'] = Product::where('overall_status',2)->where('archive',null)->whereRaw('YEAR(created_at)= ?', array($data['year']))->get();
        $data['customer_completed_reports_2'] = Product::where('overall_status',2)->where('archive',1)->whereRaw('YEAR(created_at)= ?', array($data['year']))->get();


        $data['customer_completed_reports'] = $data['customer_completed_report_1']->merge($data['customer_completed_reports_2']);

        // $data['customer_completed_reports'] = Customer::whereIn("id",$customer_ids)->where("sms_status",Null)->get();
        // return $data['customer_completed_reports'] = Customer::whereIn("id",$customer_ids)->where("sms_status",0)->get();

        return View('admin.sid.customers.sendsms', $data);
    }

    public function sendsms_create(Request $r){
 
      if ($r->customer_id == Null) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Please select customer(s) before issuing SMS. Thank You');
            return redirect()->back();
    }

     $contacts = Customer::WhereIn("id",$r->customer_id)->pluck('company_phone')->toArray();
    //  $names    = Customer::WhereIn("id",$r->customer_id)->pluck('first_name')->toArray();
     for ($i=0; $i < count($contacts) ; $i++) { 
        SendSMS::sendMessage('Hello, Kindly visit our office for your report within a week or contact us if you prefer EMS Services. CPMR, Mampong-Akuapem. Thank you',$contacts[$i]);
        Customer::WhereIn("id",$r->customer_id)->update(['sms_status' => 2]);
      }
    Session::flash("message", "Message Successfully Sent. ");
    Session::flash("message_title", "success");
    return redirect()->route('admin.sid.customer.sendsmsindex');
  
    }

    //**************************************** */ PRODUCT SECTION ******************************************
    public function product_index()
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(3)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        $data['year'] = \Carbon\Carbon::now()->year;

        $data['price_list'] = ProductPriceList::where('action',1)->first();

        $data['all_product'] = Product::whereHas("departments", function ($q) use ($data) {
             return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
         })->get();
      
       
    //   $product = Product::where('phyto_hod_evaluation',2)->orderBy('id', 'DESC')->with("departments")->get();
        $data['from_date'] = Null;
        $data['to_date'] = Null;
        $data['products'] = Product::orderBy('id', 'DESC')->with("departments")->whereRaw('YEAR(created_at)= ?', array($data['year']))->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();

        return View('admin.sid.products.create', $data);
    }

    public function product_store(StoreProductRequest $request)
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(4)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        
        if ($request->micro_hod_evaluation && $request->pharm_hod_evaluation && $request->phyto_hod_evaluation ) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Sorry! Product cant be registerd. PLease check single lab appropriately');
            return redirect()->back();
        }

        $check_lab = $request->micro_hod_evaluation + $request->pharm_hod_evaluation + $request->phyto_hod_evaluation;
        $price_list = ProductPriceList::where('action',1)->first();

        if ($check_lab ==1) {
            $singleprice = $price_list->singlelab_price;

          if ($request->price > $singleprice) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Total price of single Lab test must not be above '.$price_list->singlelab_price.' ');
            return redirect()->back();

          }
        }
        if ($check_lab ==2) {
            $multiprice = $price_list->mutilabs_price;
            if ($request->price > $multiprice) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Total price of multiple lab test must not be above '.$price_list->mutilabs_price.' ');
                return redirect()->back();

              }
        }
        

        $single_multiple_lab =Null;
        $micro_grade =Null;
        $pharm_grade =Null;
        $phyto_grade =Null;
        $actual_price = $price_list->alllabs_price;

        
       
        if ($request->single_multiple_lab ==1) {
             
            if ($check_lab <1) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select single lab');
                return redirect()->back();
            }
            if ($check_lab >1) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select only one lab');
                return redirect()->back();
            }
            $single_multiple_lab =1;
                
            if ($request->micro_hod_evaluation) {
            
                $pharm_grade =2;
                $phyto_grade =2;
            }

            if ($request->pharm_hod_evaluation) {
                $micro_grade =2;
                $phyto_grade =2;
            }

            if ($request->phyto_hod_evaluation) {
                $micro_grade =2;
                $pharm_grade =2;
            }
           $actual_price = $price_list->singlelab_price;
       }

       if ($request->single_multiple_lab ==2) {
        
        if ($check_lab <2) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Please select multiple labs');
            return redirect()->back();
          }
          $single_multiple_lab =2;

            if ($request->micro_hod_evaluation && $request->pharm_hod_evaluation) {
                $phyto_grade =2;
            }
            if ($request->micro_hod_evaluation && $request->phyto_hod_evaluation) {
                $pharm_grade =2;
            }
            if ($request->phyto_hod_evaluation && $request->pharm_hod_evaluation) {
                $micro_grade =2;
            }
            $actual_price = $price_list->mutilabs_price;

       }
          
      
        $data = ([
            'name' => $request->name,
            'product_type_id' => $request->product_type_id,
            'customer_id' => $request->customer_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'receipt_num' => $request->receipt_num,
            'mfg_date' => $request->mfg_date,
            'exp_date' => $request->exp_date,
            'dosage' => $request->dosage,
            'indication' => $request->indication,
            'single_multiple_lab' => $single_multiple_lab,
            'micro_grade' => $micro_grade,
            'pharm_grade' => $pharm_grade,
            'phyto_grade' => $phyto_grade,
            'actual_price'=> $actual_price,
            'added_by_id' => Auth::guard('admin')->id(),
        ]);
        //   return $data;
        
        $product_type = ProductType::findOrFail($data['product_type_id']);
        $customer = Customer::findOrFail($request->customer_id);
        $data["code"] = Product::generateCode($product_type,$customer);
        Product::create($data);

        $actualprice = [$price_list->singlelab_price,$price_list->mutilabs_price,$price_list->alllabs_price];
        if (!in_array($request->price,$actualprice)) {
            $sms_status = 0;
        }else { 
            $sms_status = 1;
          if ($customer->code == 'G') {
             SendSMS::sendMessage('Hi '.$customer->name.',thank you for submitting your product '.$request->name.'  to CPMR for analyses. The result of the analyses will be ready within 6 Weeks.',$customer->tell);
          }else {
             SendSMS::sendMessage('Hi '.$customer->name.',thank you for submitting your product '.$request->name.'  to CPMR for analyses. The result of the analyses will be ready within 3 months.',$customer->tell);
          }
        }

        $customer->update(['sms_status' => $sms_status]);

        Session::flash("message", "Product Successfully Created. ");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.product.create')
            ->with('success', 'Product Created successfully');
    }

    public function product_edit(Product $id)
    {

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(4)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        
        $data['products'] = Product::orderBy('id', 'DESC')->get();
        $data['price_list'] = ProductPriceList::where('action',1)->first();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();
        $data['p'] = $id;


        return View('admin.sid.products.update', $data);
    }

    public function product_show(Product $id)
    {
        $data['checkperm'] = Admin::find(Auth::guard('admin')->id())->hasPermission(1);

        $data['product'] = $id; 
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(3)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

        $data['product_history']= Product::where('failed_tag',$id->failed_tag)->whereNotNull('failed_tag')->get();

        // Cover Letter //
        $data['phyto_chemicalconstsreport'] = PhytoChemicalConstituentsReport::where('product_id',$id->id)->get();
        
        return view('admin.sid.products.show', $data);
    }

    public function product_update(UpdateProductRequest $request, $id)
    {
        // dd($request->all());
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(4)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
         $p = Product::find($id);
        if ($p->product_type_id != $request->product_type_id) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Sorry! Product Category cant be edited due to  code generation');
            return redirect()->back();
        }

        if ($request->micro_hod_evaluation && $request->pharm_hod_evaluation && $request->phyto_hod_evaluation ) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Sorry! Product cant be registerd. PLease check single lab appropriately');
            return redirect()->back();
        }
        $check_lab = $request->micro_hod_evaluation + $request->pharm_hod_evaluation + $request->phyto_hod_evaluation;
        $price_list = ProductPriceList::where('action',1)->first();

        $single_multiple_lab =Null;
        $micro_grade =Null;
        $pharm_grade =Null;
        $phyto_grade =Null;
        $actual_price = $price_list->alllabs_price;

   
        if ($request->single_multiple_lab ==1) {
            if ($check_lab <1) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select single lab');
                return redirect()->back();
            }
            if ($check_lab >1) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select only one lab');
                return redirect()->back();
            }
            $single_multiple_lab =1;
                
            if ($request->micro_hod_evaluation) {
            
                $pharm_grade =2;
                $phyto_grade =2;
            }

            if ($request->pharm_hod_evaluation) {
                $micro_grade =2;
                $phyto_grade =2;
            }

            if ($request->phyto_hod_evaluation) {
                $micro_grade =2;
                $pharm_grade =2;
            }
            $actual_price = $price_list->singlelab_price;
       }
       if ($request->single_multiple_lab ==2) {
        
        if ($check_lab <2) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Please select multiple labs');
            return redirect()->back();
          }
          $single_multiple_lab =2;

            if ($request->micro_hod_evaluation && $request->pharm_hod_evaluation) {
                $phyto_grade =2;
            }
            if ($request->micro_hod_evaluation && $request->phyto_hod_evaluation) {
                $pharm_grade =2;
            }
            if ($request->phyto_hod_evaluation && $request->pharm_hod_evaluation) {
                $micro_grade =2;
            }
            $actual_price = $price_list->mutilabs_price;
     
         
       }
        $data = ([
            'name' => $request->name,
            'product_type_id' => $request->product_type_id,
            'customer_id' => $request->customer_id,
            'quantity' => $request->quantity,
            'mfg_date' => $request->mfg_date,
            'exp_date' => $request->exp_date,
            'receipt_num' => $request->receipt_num,
            'dosage' => $request->dosage,
            'indication' => $request->indication,
            'single_multiple_lab' => $single_multiple_lab,
            'micro_grade' => $micro_grade,
            'pharm_grade' => $pharm_grade,
            'phyto_grade' => $phyto_grade,
            'actual_price'=> $actual_price,

            'updated_by_id' => Auth::guard('admin')->id(),
        ]);

        Product::where('id', $id)->update($data);

        Session::flash('message_title', 'success');
        Session::flash('message', 'Product successsfully updated.');
        return redirect()->back();
    }

    public function producttype_productlist($id){
      
        $data['from_date'] = Null;
        $data['to_date'] = Null;
        $data['products'] = Product::orderBy('id', 'DESC')->where('product_type_id',$id)->get();
        $data['price_list'] = ProductPriceList::where('action',1)->first();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();

        return View('admin.sid.products.create', $data);

    }

     public function registeredproduct_report(Request $r){
   

        $data = $r->validate([
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        $data['from_date'] = $r->from_date;
        $data['to_date'] = $r->to_date;
        $data['price_list'] = ProductPriceList::where('action',1)->first();
        $data['products'] = Product::orderBy('id', 'DESC')->whereDate('created_at', '>=', $r->from_date)->whereDate('created_at','<=',$r->to_date)->doesnthave('departments')->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();
        return View('admin.sid.products.create', $data);

     }
    public function yearlyproduct_registered(Request $r){
        // dd($r->all());
        
        $data['year'] = $r->year;
        $data['price_list'] = ProductPriceList::where('action',1)->first();

        $data['all_product'] = Product::whereHas("departments", function ($q) use ($data) {
             return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
         })->get();
      
       
    //   $product = Product::where('phyto_hod_evaluation',2)->orderBy('id', 'DESC')->with("departments")->get();
        $data['from_date'] = Null;
        $data['to_date'] = Null;
        $data['products'] = Product::orderBy('id', 'DESC')->with("departments")->whereRaw('YEAR(created_at)= ?', array($data['year']))->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();

        return View('admin.sid.products.create', $data);
    }


    //*********************************************Product Category*****************************************************/


    public function product_type_index()
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(5)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        $data['product_types'] = ProductType::all();
        $data['pharm_standards'] = PharmStandards::all();

        return View('admin.sid.products.category.index', $data);
    }

    public function product_type_edit(ProductType $id){

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(5)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

        $data['p_type'] = $id;
        $data['product_types'] = ProductType::all();
        $data['pharm_standards'] = PharmStandards::all();

        return View('admin.sid.products.category.edit', $data);

    }

    public function product_category_update(Request $request, $id){

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(6)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        $data = $request->validate([
            'code' => 'required', 
            'name' => 'required|min:3', 
            'form' => 'required|numeric', 
            'state' => 'required|numeric', 
            'method_applied' => 'required|numeric', 
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
            'updated_by_id' => Auth::guard('admin')->id(),
        ]);

        ProductType::where('id', $id)->update($data);
        Session::flash("message", "Product Category Successfully Created.");
        Session::flash("message_title", "success");
        return redirect()->back();

    }


    public function product_category_store(Request $request)
    {

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(6)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
  
        $data = $request->validate([
            'code' => 'required', 
            'name' => 'required|min:3', 
            'form' => 'required|numeric', 
            'state' => 'required|numeric', 
            'method_applied' => 'required', 
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
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(9)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

        $product =  product::find($id);
        if (!$product) {
            return redirect()->back();
        }

        $data['product'] = Product::where('id', $id)->with("departments")->first();

        return View('admin.sid.accounts.index', $data);
    }

    public function account_store(Request $r, $id)
    {
        
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(10)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        //   dd($r->all(), $id);
      $price_list = ProductPriceList::where('action',1)->first();

        $data = $r->validate([
            'amt_paid' => 'required',
            'customer' => 'required',
            'receipt_num' => 'required'

        ]);
        if ($r->amt_paid >  $price_list->alllabs_price) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Amount should not be more than '.$price_list->alllabs_price.' ');
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
        
        if ($actualamt > $price_list->alllabs_price) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Amount Exceeds actual fee. NB: Product fee for all labs is GH '.$price_list->alllabs_price.'');
            return redirect()->back();
        }

        if ($product->account_status == 1) {
            $data = ([
                'product_id' => $id,
                'customer' => $r->customer,
                'receipt_num' => $product->receipt_num,
                'price' => $r->initial_amt,
                'added_by_id' => Auth::guard('admin')->id(),

            ]);
            Account::create($data);
        }

            $data = ([
                'product_id' => $id,
                'customer' => $r->customer,
                'receipt_num' => $r->receipt_num,
                'price' => $r->amt_paid,
                'added_by_id' => Auth::guard('admin')->id(),

            ]);
            Account::create($data);

            $data = ([
                'account_status' => 2,
                'price' => $actualamt
            ]);
            Product::where('id', $id)->where('price', '=', $r->initial_amt)->update($data);

            $price_list = ProductPriceList::where('action',1)->first();
            $c_details = Customer::find($product->customer_id);
            $pricelisted = [$price_list->singlelab_price,$price_list->mutilabs_price,$price_list->alllabs_price];

            if (!in_array($actualamt,$pricelisted)) {
               $sms_status = 0;
            }else { 
                $sms_status = 1;
                if ($c_details->sms_status < 1) {
            //   SendSMS::sendMessage('Hi '.$c_details->name.',thanks you for submitting your product '.$request->name.'  to CPMR for analyses. The result of the analyses will be ready within 3 months.',$c_details->tell);
                }
            }
            // $c_details->update(['sms_status' => $sms_status]);

        return redirect()->route('admin.sid.product.account.index', ['id' => $product->id, 'price' => $product->price]);
    }

    public function account_delete($p_id, $act_id, $price)
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(10)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

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
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(11)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        //     return \App\Product::find(3)->productDept()->where('dept_id',1)->get();
        //    die();

        $data['dept'] = Department::where('dept_type_id', 1)->get();

        $data['products'] = Product::orderBy('id', 'DESC')->doesnthave('departments')->get();

        $data['productdepts'] = Product::orderBy('id', 'DESC')->whereDoesntHave('productDept')->get();



        return View('admin.sid.distribution.create', $data);
    }

    public function distribute_depts_store(ProductDistributionRequest $request)
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(12)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

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
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(12)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        
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

        if (Product::where('overall_status', 0)) {
            Product::where('id',  $request->product_id)->update(['overall_status' => 1]);
        }

        Session::flash("message", "Product Successfully Distributed.");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.distribution.create')
            ->with('success', 'Product Distributed successfully');
    }




    //**************************************Product Distribution Delete section for all departments  **************************** */

    public  function deleteProduct($id, $dept_id, $activetab = null)
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(12)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        Session::flash('activetab', !blank($activetab) ? $activetab : 0);

        $product_dept = ProductDept::where('product_id', $id)->where('dept_id', $dept_id)->first();
        if ($product_dept->status == 1) {
            $product_dept->delete();
            $p = Product::find($id)->whereDoesntHave('productDept');
            if ($p) {
                $data = ([
                    'overall_status' => 0,
                    'single_multiple_lab' => Null,
                    'micro_grade' => Null,
                    'phyto_grade' => Null,
                    'pharm_grade' => Null,

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
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(27)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');
        } 

        $data['from_date'] = "2020-01-01";
        $data['to_date'] = now();
        $data['single_multiple_lab'] = 0;
        $data['year'] = \Carbon\Carbon::now()->year;

       $data['products'] = \App\Product::whereRaw('YEAR(created_at)= ? ',array($data['year']))->count();
       $data['single_lab'] = \App\Product::where('single_multiple_lab',1)->whereRaw('YEAR(created_at)= ? ',array($data['year']))->count();
       $data['multiple_labs'] = \App\Product::where('single_multiple_lab',2)->whereRaw('YEAR(created_at)= ? ',array($data['year']))->count();
       $data['all_labs'] = \App\Product::where('single_multiple_lab',Null)->whereRaw('YEAR(created_at)= ? ',array($data['year']))->count();


    //    $data['product_types'] = \App\ProductType::with(['pending','completed'])->get();

       $data['product_types'] = \App\ProductType::with(['pending'=>function($query) use ($data){
        $query->whereHas("departments",function ($q) use ($data) {
        return $q->whereRaw('YEAR(received_at)= ? ',array($data['year']));
         });
       },
       'completed'=>function($query) use ($data){
        $query->whereHas("departments",function ($q) use ($data) {
                    return $q->whereRaw('YEAR(received_at)= ? ',array($data['year']));
                });
        }])->get();

        return View('admin.sid.generalreport.index', $data);
    }


    public function generalyearly_report(Request $r)
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(27)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');
        } 

        $data = $r->all();
        $data['product_types'] = \App\ProductType::all();

        //  $data['from_date'] =$r->from_date;
        //  $data['to_date'] =$r->from_date;
        $data['single_multiple_lab'] = Null;
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
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(27)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');
        } 

        $data = $r->all();
        if ($r->from_date == null) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Please select required date to begin');
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
        $data['year'] = \Carbon\Carbon::now()->year;
        $data['products'] = \App\Product::whereHas("departments", function ($q) use ($r) {
            return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
           })->count();
        $data['single_lab'] = \App\Product::where('single_multiple_lab',1)->whereHas("departments", function ($q) use ($r) {
         return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
        })->count();
       $data['multiple_labs'] = \App\Product::where('single_multiple_lab',2)->whereHas("departments", function ($q) use ($r) {
        return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
       })->count();
       $data['all_labs'] = \App\Product::where('single_multiple_lab',Null)->whereHas("departments", function ($q) use ($r) {
        return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
       })->count();

        if ($r->single_multiple_lab >0) {

            $data['single_multiple_lab'] = $r->single_multiple_lab;
        }

        if ($r->single_multiple_lab <1) {
            $data['single_multiple_lab'] = 0;
        }
    

        $single_multiple_lab = Null;

        if ($r->single_multiple_lab == Null) {
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
    
        }

        if ($r->single_multiple_lab == 1) {
            $data['product_types'] = \App\ProductType::with(['singlelabpending'=>function($query) use ($r){
                $query->whereHas("departments",function ($q) use ($r) {
                return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                 });
             },
            'singlelabcompleted'=>function($query) use ($r){
                $query->whereHas("departments",function ($q) use ($r) {
                            return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                        });
             }])->get();
    
        }
     
        if ($r->single_multiple_lab == 2) {
            $data['product_types'] = \App\ProductType::with(['multiplelabpending'=>function($query) use ($r){
                $query->whereHas("departments",function ($q) use ($r) {
                return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                 });
             },
            'multiplelabcompleted'=>function($query) use ($r){
                $query->whereHas("departments",function ($q) use ($r) {
                            return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                        });
             }])->get();
    
        }
        if ($r->single_multiple_lab== 3) {

            $data['product_types'] = \App\ProductType::with(['all_labpending'=>function($query) use ($r){
                $query->whereHas("departments",function ($q) use ($r) {
                return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                 });
             },
            'all_labcompleted'=>function($query) use ($r){
                $query->whereHas("departments",function ($q) use ($r) {
                            return $q->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
                        });
             }])->get();
    
        }
     

        return view('admin.sid.generalreport.index', $data);
    }


    public function completedreports_index(Request $r)
    {
       
       
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(27)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');
        } 

        $data['ptype_id'] = $r->product_type_id;
        $data['single_multiple_lab'] = $r->single_multiple_lab;
        $data['singlelab_completed'] = $r->singlelabcompleted;
        $data['multiple_labcompleted'] = $r->multiplelabcompleted;
        $data['all_labcompleted'] = $r->all_labcompleted;

        $data['completed_reports'] = $r->completed_reports;

        $data['final_reports'] = \App\ProductType::where('id',$r->product_type_id)->first();

        return view('admin.sid.generalreport.finalreports', $data);
    }

    public function pendingreports_index(Request $r, $id)
    {
        if ($r->pending_report_ids == Null) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'Sorry there are no record to view');
            return redirect()->back();
        }

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(27)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');
        } 

             $data['ptype_id'] = $id;
             $data['final_reports'] = Product::where('product_type_id', $id)
            ->where('micro_hod_evaluation', 2)->where("pharm_hod_evaluation", 2)->where('phyto_hod_evaluation', 2)->with('departments')->wherehas('departments')->get();

            
           $data['pending'] = Product::whereIn('id',$r->pending_report_ids)->with('departments')->pluck('id')->toArray();
           $data['dept'] = Department::where('dept_type_id', 1)->get();
           $data['pending_overview'] = Product::whereIn('id',$r->pending_report_ids)->with('departments')->get();


        //    $data['dept1'] = Department::find(1)->products()->whereIn('product_id',$pending)->with('departments')->orderBy('status')->get();
         
        return view('admin.sid.generalreport.pending', $data);
    }

    public function completedreports_show($id)
    {
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(28)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

       return $data['report_id'] = $id;

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


    public function review_product(Product  $products, $id){
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(7)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        // return $product->failed_final_grade? "yes": "no";
        $product = $products->where('id',$id)->first();
        $p_last = $product->last_review_product;
        if (!$p_last->failed_final_grade) {
          Session::flash('message_title', 'error');
          Session::flash('message', 'Sorry Product has passed all lab tests and cant be reviewed.');
          return redirect()->back();
        } 
       
        // if ($p_last->pending_review_product) {
        //     Session::flash('message_title', 'error');
        //     Session::flash('message', 'Sorry Product cant be reviewed. Process Pending');
        //     return redirect()->back();
        // }
        $data['products'] = Product::orderBy('id', 'DESC')->with("departments")->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id', 'DESC')->get();

        $data['p'] = Product::where('id',$id)->first();

        return View('admin.sid.products.review', $data);

    }

    public function review_create(Request $request, $id){

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(8)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        // dd($request->all());
       $failed_tag = $request->failed_tag;
        $micro_grade =Null;
        $pharm_grade =Null;
        $phyto_grade =Null;
        $micro_hod_evaluation =Null;
        $pharm_hod_evaluation =Null;
        $phyto_hod_evaluation =Null;

        $p = Product::find($id);
       if ($p->failed_tag) {
           $failed_tag= $p->failed_tag;
       }else{
        $data = (['failed_tag' => $request->failed_tag]);
        Product::where('id', $id)->update($data);
       }
       if ($p->micro_grade == 2) {
        $micro_grade = 2;
        $micro_hod_evaluation = 2;
       }
       if ($p->pharm_grade == 2) {
        $pharm_grade = 2;
        $pharm_hod_evaluation = 2;
       }
       if ($p->phyto_grade == 2) {
        $phyto_grade = 2;
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
        'receipt_num' => $p->receipt_num,
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
  
    $product_type = ProductType::findOrFail($data['product_type_id']);
    $data["code"] = Product::generateCode($product_type);
    Product::create($data);
    Session::flash("message", "Product Successfully Created.");
    Session::flash("message_title", "success");
    return redirect()->route('admin.sid.product.create')
        ->with('success', 'Product Created successfully');
    }

    //******************************************************************* SID Configuration (Admin)************************************* */
    public function create_admin(Admin $admin){

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(23)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');
        } 
 
        $data['depts'] = \App\Department::all();
        $data['user_types'] = \App\UserType::all();
        $data['dept_offices'] = \App\DeptOffice::all();
         $data['admins'] = Admin::all();
        return view('admin.auth.createadmin',$data);
        
    }

    public function registeradmin_store(Request $r){
  
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(24)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        $data = $r->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'dept_id' => 'required',
            'position' => 'required',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed',
            'pin' => 'required|min:4|confirmed',

        ]);

        if ($r->has('select_file')) {
            $image = $r->file('select_file');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $folder = '/admin/img/';
            $filePath = $folder . $new_name;
            
            $image->move(public_path('admin\img'), $new_name); 
            $r->sign_url = $filePath;
        }

        $efficacy_analysis_option = Null;
        $load_analysis_option = Null;

        $organolepticts_option = Null;
        $physicochemical_option = Null;
        $chemical_constituents_option = Null;


        if ($r->dept_id == 1) {
            $efficacy_analysis_options = MicrobialEfficacyAnalyses::pluck("id")->toArray();
            $efficacy_analysis_option = json_encode($efficacy_analysis_options);
    
            $load_analysis_options = MicrobialLoadAnalyses::pluck("id")->toArray();
            $load_analysis_option = json_encode($load_analysis_options);
        }
        if ($r->dept_id == 3) {
            $organolepticts_options = PhytoOrganoleptics::pluck("id")->toArray();
            $organolepticts_option = json_encode($organolepticts_options);
    
            $physicochemical_options = PhytoPhysicochemData::pluck("id")->toArray();
            $physicochemical_option = json_encode($physicochemical_options);
            
            $chemical_constituents_options = PhytoChemicalConstituents::pluck("id")->toArray();
            $chemical_constituents_option = json_encode($chemical_constituents_options);
        }

        $data = ([
            'title' => $r->title,
            'first_name' => $r->first_name,
            'last_name' => $r->last_name,
            'position' => $r->position,
            'dept_id' => $r->dept_id,
            'user_type_id' => $r->user_type_id,
            'dept_office_id' => $r->dept_office_id,
            'sign_url' => $r->sign_url,
            'tell' => $r->tell,
            'email' => $r->email,
            'efficacy_analysis_options' => $efficacy_analysis_option, 
            'load_analysis_options' => $load_analysis_option,   
            'organolepticts_options' => $organolepticts_option, 
            'physicochemical_options' => $physicochemical_option, 
            'chemical_constituents_options' => $chemical_constituents_option,   
            'password' => bcrypt($r->password),
            'pin' => bcrypt($r->pin),

        ]);
        Admin::create($data);

        Session::flash("message", "User Successfully Created.");
        Session::flash("message_title", "success");
        return redirect()->back();
    }

    public function user_permisions(){
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(23)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
     $data['user_types'] = UserType::with('permissions')->get();
     return view('admin.auth.roles.permissions',$data);
    }

    public function user_permisions_edit($id){

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(23)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 

    $data['all_usertypes'] = UserType::with('permissions')->get();
    $data['user_types'] = UserType::where('id',$id)->with('permissions')->get();
    $data['user_type'] = UserType::where('id',$id)->first();

        return view('admin.auth.roles.edit',$data);
    }
    
    public function permissions_update(Request $r){

        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(24)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
    //  dd($r->all());
    //    return $r->measurement;
        $usertype =  UserType::with('permissions')->get();
        $user_type = Usertype::findOrFail($r->user_types_id);

       foreach($r->permit as $key => $pmt){
        $user_type->permissions()->updateExistingPivot($key, array('enabled'=>$pmt,  'created_at'=>\Carbon\Carbon::now()), TRUE);   
        }

        return redirect()->back();
    }

    public function user_editadmin($id){
    
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(23)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');

        } 
        $data['depts'] = \App\Department::all();
        $data['user_types'] = \App\UserType::all();
        $data['dept_offices'] = \App\DeptOffice::all();
        $data['admins'] = Admin::all();
        $data['admin'] = Admin::findorFail($id);

        return view('admin.auth.editadmin',$data);
    }



       public function user_updateadmin(Request $r, $id){
        //    dd($r->all());
         $user = Admin::find($id);
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(24)) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
            return redirect()->route('admin.general.dashboard');
        }

            $data = $r->validate([
                'title' => 'required',
                'first_name' => 'required|max:255|min:3',
                'last_name' => 'required|max:255|min:3',
                'dept_id' => 'required',
                'position' => 'required',
                'email' => 'required|email|unique:users,email,'.$user->id.',id',
                'user_type_id' => 'required',
                'dept_office_id' => 'required',
                'tell' => 'required',
            ]);

            if ($r->has('select_file')) {
                $image = $r->file('select_file');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $folder = '/admin/img/';
                $filePath = $folder . $new_name;
                
                $image->move(public_path('admin\img'), $new_name); 
                $r->sign_url = $filePath;
            }

            $efficacy_analysis_option = Null;
            $load_analysis_option = Null;
    
            $organolepticts_option = Null;
            $physicochemical_option = Null;
            $chemical_constituents_option = Null;
    
            if ($r->dept_id == 1) {
                $efficacy_analysis_options = MicrobialEfficacyAnalyses::pluck("id")->toArray();
                $efficacy_analysis_option = json_encode($efficacy_analysis_options);
        
                $load_analysis_options = MicrobialLoadAnalyses::pluck("id")->toArray();
                $load_analysis_option = json_encode($load_analysis_options);
            }

            if ($r->dept_id == 3) {
                $organolepticts_options = PhytoOrganoleptics::pluck("id")->toArray();
                $organolepticts_option = json_encode($organolepticts_options);
        
                $physicochemical_options = PhytoPhysicochemData::pluck("id")->toArray();
                $physicochemical_option = json_encode($physicochemical_options);
                
                $chemical_constituents_options = PhytoChemicalConstituents::pluck("id")->toArray();
                $chemical_constituents_option = json_encode($chemical_constituents_options);
            }
          
          
   
            $data = ([
                'title' => $r->title,
                'first_name' => $r->first_name,
                'last_name' => $r->last_name,
                'position' => $r->position,
                'dept_id' => $r->dept_id,
                'user_type_id' => $r->user_type_id,
                'sign_url' => $r->sign_url,
                'email' => $r->email,
                'dept_office_id' => $r->dept_office_id,
                'efficacy_analysis_options' => $efficacy_analysis_option, 
                'load_analysis_options' => $load_analysis_option,   
                'organolepticts_options' => $organolepticts_option, 
                'physicochemical_options' => $physicochemical_option, 
                'chemical_constituents_options' => $chemical_constituents_option,             
                'tell' => $r->tell,
            ]);
         Admin::where('id',$id)->update($data);

        Session::flash("message", "User Successfully updated.");
        Session::flash("message_title", "success");
        return redirect()->back();
}

      public function micro_completed_reports(){
          
    //  $data['week_start'] = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));
     $data['week_start'] = date('Y-m-d 00:00:00', strtotime('-10 days'));

     $data['weekly_microcompletedreports'] = Product::where('micro_reportdatecompleted','>=', $data['week_start'])->with('departments')->whereHas("departments", function($q){
        return $q->where("dept_id", 1)->where("status",4);
      })->orderBy('micro_reportdatecompleted', 'DESC')->get();

      $data['microcompletedreports'] = Product::where('archive',Null)->with('departments')->whereHas("departments", function($q){
        return $q->where("dept_id", 1)->where("status",4);

      })->orderBy('micro_reportdatecompleted', 'DESC')->get();
 
  

      return view('admin.sid.hodoffice.microcompletedreports',$data);
      }

      public function micro_taken_reports(Request $r){
        
        return $data['microtakenreports'] = Product::where("archive",1)->with('departments')->whereHas("departments", function($q){
        return $q->where("dept_id", 1)->where("status",4);
      })->orderBy('micro_reportdatecompleted', 'DESC')->get();

      }

       public function pharm_completed_reports(){

        // $pharmcompletedreports = Product::with('departments')->whereHas("departments", function($q){
        //     return $q->where("dept_id", 2)->where("status",'<',8);
        //   })->get();
        //   if (count($pharmcompletedreports) > 0) {
        //     Session::flash('message_title', 'error');
        //     Session::flash('message', 'Please select required date to begin');
        //   }
        $data['week_start'] = date('Y-m-d 00:00:00', strtotime('-10 days'));
        $data['weekly_pharmcompletedreports'] = Product::where('pharm_reportdatecompleted','>=', $data['week_start'])->with('departments')->whereHas("departments", function($q){
            return $q->where("dept_id", 2)->where("status",8);
          })->get();

        $data['pharmcompletedreports'] = Product::where('archive',Null)->with('departments')->whereHas("departments", function($q){
          return $q->where("dept_id", 2)->where("status",8);
        })->orderBy('pharm_reportdatecompleted', 'DESC')->get();

        return view('admin.sid.hodoffice.pharmcompletedreports',$data);
      }

      public function phyto_completed_reports(){

        $data['week_start'] = date('Y-m-d 00:00:00', strtotime('-10 days'));
        $data['weekly_phytocompletedreports'] = Product::where('phyto_reportdatecompleted','>=', $data['week_start'])->with('departments')->whereHas("departments", function($q){
            return $q->where("dept_id", 3)->where("status",4);
          })->get();

        $data['phytocompletedreports'] = Product::where('archive',Null)->with('departments')->whereHas("departments", function($q){
          return $q->where("dept_id", 3)->where("status",4);
        })->orderBy('phyto_reportdatecompleted','DESC')->get();
  
        return view('admin.sid.hodoffice.phytocompletedreports',$data);
      }


    public function phyto_completedreport_update(Request $r){
         
     $phytocompletedreports = Product::whereIn('id',$r->phyto_completedproduct_id)->with('departments')->whereHas("departments", function($q){
          return $q->where("dept_id", 3)->where("status",4);
        })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
  
        ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

         if(count($phytocompletedreports->get()) < 1){     
            return redirect()->back();
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'Check error! count is more than one');
            return redirect()->back();
          }

         if ($r->condition == Null) {
          
            $data = 
            [ 
            'status' => 3,
            ];   
            ProductDept::whereIN('product_id', $r->phyto_completedproduct_id)->where("dept_id", 3)->where("status",4)->update($data);

            Product::with('departments')->whereIN('id',$r->phyto_completedproduct_id)->whereHas("departments", function($q){
            return $q->where("dept_id", 3);
           })->update(['archive' => Null]);

           }
          
           if ($r->condition == 1) {   
              $phytodept = Product::with('departments')->whereIN('id',$r->phyto_completedproduct_id)->whereHas("departments", function($q){
                return $q->where("dept_id",">",0)->where("status","!=",4)->where("status","!=",8);
               })->first();
            
            if ($phytodept != null) {
            Session::flash('messagetitle', 'warning');
            Session::flash('message', 'Sorry all departments must be completed before archiving/Completing report. Please check indications on lab status.');
            return redirect()->back();
            }else{
            Product::with('departments')->whereIN('id',$r->phyto_completedproduct_id)->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status",4);
                })->update(['archive' => 1]);
            }        
           }
        
         Session::flash("message", "Report Successfully Completed.");
         Session::flash("message_title", "success");
        

           return redirect()->back();
      }

       public function pharm_completedreport_update(Request $r){
      
       
         $pharmcompletedreports = Product::whereIn('id',$r->pharm_completedproduct_id)->with('departments')->whereHas("departments", function($q){
          return $q->where("dept_id", 2)->where("status",8);
         });

         if(count($pharmcompletedreports->get()) < 1){  
            Session::flash('message_title', 'error');
            Session::flash('message', 'Please select required product');   
            return redirect()->back();
          }


          if ($r->condition == Null) {
          
            $data = 
            [ 
            'status' => 7,
            ];   
  
           ProductDept::whereIN('product_id', $r->pharm_completedproduct_id)->where("dept_id", 2)->where("status",8)->update($data);
           Product::with('departments')->whereIN('id',$r->pharm_completedproduct_id)->whereHas("departments", function($q){
            return $q->where("dept_id", 2);
           })->update(['archive' => Null]);
           }

           if ($r->condition == 1) {   
            $pharmdept = Product::with('departments')->whereIN('id',$r->pharm_completedproduct_id)->whereHas("departments", function($q){
              return $q->where("dept_id",">",0)->where("status","!=",4)->where("status","!=",8);
             })->first();
          
          if ($pharmdept != null) {
          Session::flash('messagetitle', 'warning');
          Session::flash('message', 'Sorry all departments must be completed before archiving/Completing report. Please check indications on lab status.');
          return redirect()->back();
          }else{
          Product::with('departments')->whereIN('id',$r->pharm_completedproduct_id)->whereHas("departments", function($q){
              return $q->where("dept_id", 2);
              })->update(['archive' => 1]);
          }        
         }
        
         Session::flash("message", "Report Successfully Completed.");
         Session::flash("message_title", "success");
         return redirect()->back();
      }


      public function micro_completedreport_update(Request $r){
     
      
        $microcompletedreports = Product::whereIn('id',$r->micro_completedproduct_id)->with('departments')->whereHas("departments", function($q){
          return $q->where("dept_id", 1)->where("status",4);
        });

         if(count($microcompletedreports->get()) < 1){     
            return redirect()->route('admin.sid.micro_completed_reports');
        }

           if ($r->condition == Null) {
          
            $data = 
            [ 
            'status' => 3,
            ];   
  
           ProductDept::whereIN('product_id', $r->micro_completedproduct_id)->where("dept_id", 1)->where("status",4)->update($data);
           Product::with('departments')->whereIN('id',$r->micro_completedproduct_id)->whereHas("departments", function($q){
            return $q->where("dept_id", 1);
           })->update(['archive' => Null]);   
            }
 
          
            if ($r->condition == 1) {   
                $pharmdept = Product::with('departments')->whereIN('id',$r->micro_completedproduct_id)->whereHas("departments", function($q){
                  return $q->where("dept_id",">",0)->where("status","!=",4)->where("status","!=",8);
                 })->first();
              
              if ($pharmdept != null) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'Sorry all departments must be completed before archiving/Completing report. Please check indications on lab status.');
              return redirect()->route('admin.sid.micro_completed_reports');
              }else{
              Product::with('departments')->whereIN('id',$r->micro_completedproduct_id)->whereHas("departments", function($q){
                  return $q->where("dept_id", 1);
                  })->update(['archive' => 1]);
              }        
             }
            
        
        Session::flash("message", "Report Successfully Completed.");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.micro_completed_reports');

      }

      public function micro_completed_yearlyreports(Request $r){
          
       
        $data['year'] = $r->year;

        $data['week_start'] = date('Y-m-d 00:00:00', strtotime('-10 days'));

        $data['weekly_microcompletedreports'] = Product::where('micro_reportdatecompleted','>=', $data['week_start'])->with('departments')->whereHas("departments", function($q){
           return $q->where("dept_id", 1)->where("status",4);
         })->orderBy('micro_reportdatecompleted', 'DESC')->get();
   
         $data['microcompletedreports'] = Product::whereRaw('YEAR(created_at)= ?', array($data['year']))->with('departments')->whereHas("departments", function($q){
           return $q->where("dept_id", 1)->where("status",4);
         })->orderBy('micro_reportdatecompleted', 'DESC')->get();
         
         return view('admin.sid.hodoffice.microcompletedreports',$data);

      }

      //*************************************************************** All Downloads ********************************************************* */

      
     public function deliverysheet_pdf(Request $r){
        $product_id = $r->product_id;
    if ($product_id == Null) {
        Session::flash('message_title', 'error');
        Session::flash('message', 'Sorry! Delivery sheet has no product(s)');
        return redirect()->route('admin.sid.product.create');
    }
      $data['products'] = Product::whereIn('id',$r->product_id)->orderBy('id', 'DESC')->get();

     $pdf = \PDF::loadView('admin.sid.downloads.deliverysheet',$data);

     $pdf->save(storage_path().'_filename.pdf');

     return $pdf->download('deliverysheet.pdf');

     // return view('admin.micro.downloads.report',$data)

     }

     public function reportindex_pdf($from_date, $to_date, $smlab){

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
                
        $data['single_multiple_lab'] = $smlab;

            if ($smlab == 0) {
              
                $data['product_types'] = \App\ProductType::with(['pending'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                    return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                    });
                },
                'completed'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                                return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                            });
                }])->get();
                
            }


            if ($smlab == 1) {
                $data['product_types'] = \App\ProductType::with(['singlelabpending'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                    return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                        });
                    },
                'singlelabcompleted'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                                return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                            });
                    }])->get();

            }
            
            if ($smlab== 2) {
                
                $data['product_types'] = \App\ProductType::with(['multiplelabpending'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                    return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                        });
                    },
                'multiplelabcompleted'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                                return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                            });
                    }])->get();

            }
            if ($smlab == 3) {

                $data['product_types'] = \App\ProductType::with(['all_labpending'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                    return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                        });
                    },
                'all_labcompleted'=>function($query) use ($from_date,$to_date){
                    $query->whereHas("departments",function ($q) use ($from_date,$to_date) {
                                return $q->whereDate('product_depts.created_at', '>=', $from_date)->whereDate('product_depts.created_at', '<=', $to_date);
                            });
                    }])->get();

            }


         

        $pdf = \PDF::loadView('admin.sid.downloads.reportindexsheet',$data);

        $pdf->save(storage_path().'_filename.pdf');
   
        return $pdf->download('generalreport.pdf');

    }
     
    public function coverletter_create(Request $r){

        $data = ([
            'cover_letter' => $r->coverletter,
        ]);
        Product::where('id', $r->product_id)->update($data);
        // Session::flash('activetab', !blank($request->activetab) ? $request->activetab : 0);

        Session::flash("message", "Cover Letter Successfully Saved.");
        Session::flash("message_title", "success");
        return redirect()->back();
    }

    public function coverletter_pdf($id) {

       $data['product_coverletter'] = Product::where('id', $id)->first();

       $pdf = \PDF::loadView('admin.sid.downloads.coverletter', $data);

       $pdf->save(storage_path().'_filename.pdf');
  
       return $pdf->download('coverletter.pdf');

    }

       public function querry_report(){
         
         $tell = '0245486001';
        SendSMS::sendMessage('Hi mike,thank you for submitting your product nibima to CPMR for analyses. The result of the analyses will be ready within 6 Weeks.',$tell);

        $data['reportquerry'] = Customer::where('code','G')->with("product")->get();

        return View('admin.sid.generalreport.allquerry', $data);
       }

       
       public function audit_index(){
       
        // $get_customerid = Product::where('archive',1)->pluck('customer_id')->toArray();

        //  $customer_id = array_unique( $get_customerid );

        //  $data['customers'] = Customer::whereIN('id',$customer_id)->whereHas('product')->get();

        $data['year'] = date('Y');
        $data['curentyear'] = date('Y');

        $data['report_history'] = Product::where('archive',1)->with('departments')->whereHas("departments", function($q) use ($data){
           return $q->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
         })->orderBy('created_at', 'DESC')->get();

        return View('admin.sid.audit.index', $data);
      }

      public function audit_querry(Request $r){
          
        $data['year'] = $r->year;
        $data['curentyear'] = $r->year;

        $data['report_history'] = Product::where('archive',1)->with('departments')->whereHas("departments", function($q) use ($data){
            return $q->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
          })->orderBy('created_at', 'DESC')->get();
         
          return View('admin.sid.audit.index', $data);
        }



       public function report_history(){

         $data['year'] = date('Y');
         $data['curentyear'] = date('Y');
         $data['report_history'] = Product::where('archive',1)->with('departments')->whereHas("departments", function($q) use ($data){
            return $q->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
          })->orderBy('created_at', 'DESC')->get();
        
        //   $data['microcompletedreports'] = Product::with('departments')->whereHas("departments", function($q){
        //     return $q->where("dept_id", 1)->where("status",4);
        //   })->orderBy('micro_reportdatecompleted', 'DESC')->get();

            return View('admin.sid.generalreport.reporthistory', $data);
       }
       
      public function yearlyreport_history(Request $r){
          
        $data['year'] = $r->year;
        $data['curentyear'] = $r->year;

        $data['report_history'] = Product::where('archive',1)->with('departments')->whereHas("departments", function($q) use ($data){
            return $q->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
          })->orderBy('created_at', 'DESC')->get();
         
          return View('admin.sid.generalreport.reporthistory', $data);
      }


       public function reject_archived_report(Request $r){


        Product::with('departments')->whereIN('id',$r->sid_arcivereport_id)->whereHas("departments", function($q){
            return $q->where("status",">",3);
            })->update(['archive' => Null]);

            Session::flash("message", "Report Successfully Rejected.");
             Session::flash("message_title", "success");
            return redirect()->route('admin.sid.reporthistory');


        }
       


}
