@extends('admin.layout.main')

@section('content')

<div class="">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-edit bg-blue"></i>
                            <div class="d-inline">
                                <h5>Micro Completed Reports </h5>
                                <span>Bellow shows all completed reports from microbiology</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Micro Completed Reports</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
            </div>
           
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  @if (count($weekly_microcompletedreports) > 0)
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Hello! {{\App\Admin::find(Auth::guard('admin')->id())?\App\Admin::find(Auth::guard('admin')->id())->full_name:'null'}} </strong> You have {{count($weekly_microcompletedreports)}} new report(s) from Microbiology Department.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ik ik-x"></i>
                    </button>
                </div>  
                  @endif
                    <div class="row align-items-center">
                        {{-- <div class="col-lg-8 col-md-12">
                            <h3 class="card-title">All Micro completed products </h3>
                            
                          </div> --}}
                        <div class="col-md-12">
                          
                            {{ Form::open(array('action'=>"AdminAuth\SID\SIDController@micro_completed_yearlyreports", 'method'=>'post','class'=>'form-horizontal')) }}
                            {{Form::token()}}
                            <div class="input-group" style=" margin-top: 10px;">
                                {{ Form::selectRange('year',date('Y') -1, date('Y'), isset($year) ?? $year, array('class'=>'form-','placeholder'=>'Select year')) }}
                                <button type="submit" class="btn btn-primay mr-2">Search</button>    
                            </span>
                            </div>
                            {{ Form::close() }} 
                            <form  id="microarchiveproduct" action="{{url('admin/sid/hod_office/micro_completed_report/update')}}" class="forms-sample" method="POST">
                                {{ csrf_field() }}

                             <table id="order-table_micro" class="table table-striped table-bordered nowrap dataTable">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>download</th>
                                        <th>Lab Status
                                        </th>
                                        <th>Date Completed</th>
                                        <th>Actions</th>
                                   </tr>
                                </thead>
                                <tbody>                                                
                                    @foreach($microcompletedreports as $product)
                                    <tr>
                                      
                                    <td class="font">
                                        <a target="blank" href="{{route('admin.sid.product.show', ['id' => $product->id])}}">
                                         

                                            @if ($product->archive == Null)
                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                {{$product->code}}
                                            </span>  
                                            @else
                                            <span  class="badge  pull-right" style="background-color:#28a745; color:#fff">
                                                <span style="font-size: 0.1px">#completed</span> {{$product->code}}
                                            </span>  
                                            @endif
                                        </a>
                                        @if($product->single_multiple_lab ==1)
                                        <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#S</span></sup>
                                        @endif
                                        @if($product->single_multiple_lab ==2)
                                        <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#M</span></sup>
                                        @endif
                                    </td>
                                    <td class="font">{{$product->name}}
                                        @if ($product->micro_reportdatecompleted >= $week_start )
                                        <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">NEW</span></sup>
                                        @endif
                                    </td>
                                    <td class="font">

                                        <div class="row">
                                            @if ($product->micro_hod_evaluation == 2)
                                            <div class="col-md-6">
                                                <a  target="_blank" href="{{route('admin.sid.print_microreport',['id' => $product->id])}}">
                                                    <button type="button" class="btn btn-outline-success btn-rounded">View Report</button>
                                                </a>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="{{route('admin.sid.microreport.pdf',['id' => $product->id])}}">
                                                    <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                                  </a>
                                            </div>
                                            @endif
                                        </div>

                                    </td>
                                    <td>
                                        
                                        @foreach ($product->ProductDept->where('dept_id',1)->where('status','>', 0) as $item)
                                         @if ($item->status == 4)
                                         <a href="#!" title="Micro"><i class="ik ik-check f-16 mr-15 text-green"></i></a>
                                         @else
                                         <a href="#!" title="Micro"><i class="ik ik-x  f-16 mr-15 text-red"></i></a>
                                         @endif
                                        @endforeach

                                        @foreach ($product->ProductDept->where('dept_id',2)->where('status','>', 0) as $item)
                                         @if ($item->status == 8)
                                         <a href="#!" title="Pharm"><i class="ik ik-check f-16 mr-15 text-green"></i></a>
                                         @else
                                         <a href="#!" title="Pharm"><i class="ik ik-x  f-16 mr-15 text-red"></i></a>
                                         @endif
                                        @endforeach

                                        @foreach ($product->ProductDept->where('dept_id',3)->where('status','>', 0) as $item)
                                        @if ($item->status == 4)
                                        <a href="#!" title="Phyto"><i class="ik ik-check f-16 mr-15 text-green"></i></a>
                                        @else
                                        <a href="#!" title="Phyto"><i class="ik ik-x  f-16 mr-15 text-red"></i></a>
                                        @endif
                                       @endforeach

                                    </td>
                                    <td class="font">
                                        {{$product->micro_reportdatecompleted}}  
                                    </td>

                                    <td class="font">
                                        <div class="form-check mx-sm-2">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input microselect" name=""  value="{{$product->id}}" >
                                                <span class="custom-control-label">&nbsp; </span>
                                            </label>
                                        </div>
                                    </td>
 
                                    </tr>
                                   
                                    @endforeach
                                </tbody>
                            </table>
                              <select name="condition" id="">
                                <option value="1">Complete Report</option>
                                  <option value="">Reject Report</option>
                              </select>
                              <button onclick="return confirm('Please comfirm selected items.')"  class="" type="submit"> Submit</button>
                            </form>
         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>


    {{-- <div class="card" style="overflow-x: scroll">
        <div class="card-body">
            <div class="text-center" style="padding: 10px"> 
                <h4> Search Micro Archived Reports</h4>
             </div>
             
           <form action="http://localhost/cpmrdrugtest/public/admin/pharm/producttype/productlist/search" class="" method="POST">
               <input type="hidden" name="_token" value="cTKV6D0mvq7aMRmw7s59SQSfRtRGdme7RJSd10CQ">
           <div class="row">
                   <div class="col-md-3">
                           <div class="form-group">
                               <select name="product_type_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                   <option value="">Select Product Type </option>                                                                    
                                   <option value="1">Not specified</option>
                                   <option value="2">Decoction</option>
                               </select>
                           </div>
                   </div>
                   <div class="col-md-3">
                       <div class="form-group">
                           <select name="status" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                               <option value="">Select Product Status </option>
                               <option value="1">Pending</option>
                               <option value="2">Received</option>
                               <option value="3">Inprogress</option>
                               <option value="8" selected="">Completed</option>  
                           </select>                         
                       </div>
                   </div>
                   <div class="col-md-3">
                       <div class="form-group">
                           <select name="date" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                               <option value="">Select Period</option>
                               <option value="1">Weekly</option>
                               <option value="2">Monthly</option>
                               <option value="3" selected="">Yearly</option>         
                           </select>                  
                       </div>
                   </div>
                   <div class="col-md-2">
                       <button type="submit" class="btn btn-primary mr-2">Search List</button>
                   </div>
               
           </div>
          </form>

          
       
        </div>
    </div> --}}
 </div>

@endsection
