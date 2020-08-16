<?php
namespace App\Http\Controllers\AdminAuth\SID;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\ProductDistributionRequest;
use App\Http\Requests\UpdatecustomerRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Customer;
use App\Department;
use App\ProductType;
use App\Product;
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
        $data['customers'] = Customer::orderBy('id','DESC')->get();
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
            'first_name' => 'required|min:3|Alpha', 
            'last_name' => 'required|min:3|Alpha', 
            'street_address' => 'required', 
            'house_number' => 'required', 
            'email' => 'required|email|max:128|unique:customers', 
            'tell' => 'required|numeric', 
        ]);
       
        $data = ([
            'title'=>$request->title,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'company'=>$request->company,
            'house_number'=>$request->house_number,
            'street_address'=>$request->street_address,
            'email'=>$request->email,
            'tell'=>$request->tell,
            'added_by_id'=>Auth::guard('admin')->id(),
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
    public function customer_update(UpdateCustomerRequest $request, $id)
    {
        $data = $request->validate([
            'first_name' => 'required|min:3|Alpha', 
            'last_name' => 'required|min:3|Alpha', 
            'street_address' => 'required', 
            'house_number' => 'required', 
            'tell' => 'required|numeric', 
        ]);
       
        $data = ([
            'title'=>$request->title,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'house_number'=>$request->house_number,
            'street_address'=>$request->street_address,
            'email'=>$request->email,
            'tell'=>$request->tell,
            'added_by_id'=>Auth::guard('admin')->id(),
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
        $data['products'] = Product::orderBy('id','DESC')->get();
        $data['product_types'] = ProductType::all();
         $data['customers'] = Customer::orderBy('id','DESC')->get();
         
        return View('admin.sid.products.create', $data); 
    }

      public function product_store(StoreProductRequest $request)
    {
        
        $data = ([
            'name'=>$request->name,
            'product_type_id'=>$request->product_type_id,
            'customer_id'=>$request->customer_id,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'mfg_date'=>$request->mfg_date,
            'exp_date'=>$request->exp_date,
            'company'=>$request->company,
            'indication'=>$request->indication,
            'added_by_id'=>Auth::guard('admin')->id(),
        ]);

        Product::create($data);
        Session::flash("message", "Product Successfully Created.");
        Session::flash("message_title", "success");
        return redirect()->route('admin.sid.product.create')
        ->with('success', 'Product Created successfully');
     }

     public function product_edit(Product $id)
     {
        $data['products'] = Product::orderBy('id','DESC')->get();
        $data['product_types'] = ProductType::all();
        $data['customers'] = Customer::orderBy('id','DESC')->get();
        $data['p'] = $id;
  
         return View('admin.sid.products.update', $data);
     } 

     public function product_show(Product $id)
     {   
         $data['product'] = $id;
       
         return view('admin.sid.products.show', $data);
     }

     public function product_update(UpdateProductRequest $request, $id)
     {      
         
        $data = ([
            'name'=>$request->name,
            'product_type_id'=>$request->product_type_id,
            'customer_id'=>$request->customer_id,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'mfg_date'=>$request->mfg_date,
            'exp_date'=>$request->exp_date,
            'company'=>$request->company,
            'indication'=>$request->indication,
            'added_by_id'=>Auth::guard('admin')->id(),
        ]);
         
         Product::where('id', $id)->update($data);
         Session::flash('message_title', 'success');
         Session::flash('message', 'Customer successsfully updated.');
          return redirect()->route('admin.sid.product.create');
     }

         //**************************************** */ PRODUCT DISTRIBUTION SECTION ******************************************
         public function distribution_index()
         {
        //     return \App\Product::find(3)->productDept()->where('dept_id',1)->get();
        //    die();
              
            $data['dept'] = Department::where('dept_type_id',1)->get();
            
            $data['products'] = Product::orderBy('id', 'DESC')->doesnthave('departments')->get();

            $data['productdepts']=Product::orderBy('id', 'DESC')->whereDoesntHave('productDept')->get();
            
              $data['pharmproducts']=Product::orderBy('id', 'DESC')->whereDoesntHave('productDept',function($q){
                $q->where('dept_id',3);})->get();

            $data['phytoproducts']=Product::orderBy('id', 'DESC')->whereDoesntHave('productDept',function($q){
                $q->where('dept_id',3);})->get();


             return View('admin.sid.distribution.create', $data); 
         }

        public function distribute_depts_store(ProductDistributionRequest $request){

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
            Session::flash("message", "Product Successfully Distrituted.");
            Session::flash("message_title", "success");
    
            return redirect()->route('admin.sid.distribution.create')
            ->with('success', 'Product Created successfully');
        }

        //******************************  Product distribution to single department ***************************** */

        public function distribute_onedept_store(Request $request){
           
            $admin_id = Auth::guard('admin')->id();

            $data = ([
                'product_id' => $request->product_id,
                'dept_id'=>$request->dept_id,
                'quantity'=>$request->microquantity,
                'distributed_by'=>$admin_id,
            ]);

            ProductDept::create($data);
            Session::flash("message", "Product Successfully Distributed.");
            Session::flash("message_title", "success");
            return redirect()->route('admin.sid.distribution.create')
            ->with('success', 'Product Distributed successfully');

        }

      


        //**************************************Product Distribution Delete section for all departments  **************************** */

        public  function deleteProduct($id, $dept_id)
        {   
         
           $product_dept= ProductDept::where('product_id',$id)->where('dept_id',$dept_id)->first();
           if($product_dept->status == 1){
            $product_dept->delete(); 
            
            Session::flash("message", "Successfully Deleted.");
            Session::flash("message_title", "success");
            return redirect()->route('admin.sid.distribution.create');
           }else{
            Session::flash('message_title', 'error');
            Session::flash('message', 'Sorry! this cant be deleted! Please contact system admin. ');
            return redirect()->back();
           }
             
        }
    



}


