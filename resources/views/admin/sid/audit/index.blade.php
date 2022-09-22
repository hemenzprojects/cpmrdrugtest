@extends('admin.layout.main')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-menu bg-blue"></i>
                <div class="d-inline">
                    <h5>Audit Section</h5>
                    <span>Bellow are completed report with customer details</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Completed Reports</li>
                    
                </ol>
            </nav>
        </div>
     
    </div>
</div>


    <div class="row align-items-center">
      <div class="card"> 
        <div class="col-md-12">
          
            {{ Form::open(array('action'=>"AdminAuth\SID\SIDController@audit_querry", 'method'=>'post','class'=>'form-horizontal')) }}
            {{Form::token()}}
            <div class="input-group" style=" margin-top: 10px;">
                {{ Form::selectRange('year',date('Y') -1, date('Y'), isset($year) ?? $year, array('class'=>'form-','placeholder'=>'Select year')) }}
                <button type="submit" class="btn btn-primay mr-2">Search</button>    
            </span>
            </div>
            {{ Form::close() }} 
            <form  id="sidarchiveproduct" action="{{url('admin/sid/reject/archivedreport')}}" class="forms-sample" method="POST">
                {{ csrf_field() }}
                <div class="text-center"> 
                    <h4 class="card-title mt-10"> {{$curentyear}} Archived Reports</h4>                           
                </div>

             <table id="order-table_micro" class="table table-striped table-bordered nowrap dataTable">
                <thead>
                    <tr>
                        <th>Product </th>
                        <th>Customer Details</th>
                        {{-- <th>download</th> --}}
                        <th>Lab Status</th>
                        <th>Date Received</th>
                        <th>Date Completed</th>
                        <th>Actions</th>
                   </tr>
                </thead>
                <tbody>                                                
                    @foreach($report_history as $product)
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
                        <br>
                        <br>
                        {{$product->name}}
                    </td>
                                        <td>
                          
                        <span> <strong>Customer Name:</strong>   {{ucfirst(\App\Customer::find($product->customer_id)? \App\Customer::find($product->customer_id)->name:'null')}}</span><br>
                        <span><strong>Company Name:</strong> {{ucfirst(\App\Customer::find($product->customer_id)? \App\Customer::find($product->customer_id)->company_name:'null')}}</span><br>
                        <span> <strong>Company Address:</strong> {{ucfirst(\App\Customer::find($product->customer_id)? \App\Customer::find($product->customer_id)->company_address:'null')}}</span><br>
                        <span> <strong>Company Tell:</strong> {{ucfirst(\App\Customer::find($product->customer_id)? \App\Customer::find($product->customer_id)->company_phone:'null')}}</span><br>
                        <span> <strong>Customer Tell:</strong> {{ucfirst(\App\Customer::find($product->customer_id)? \App\Customer::find($product->customer_id)->tell:'null')}}</span><br>
                    </td>
                    {{-- <td class="font">

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

                    </td> --}}
                    <td>
                        
                        @foreach ($product->ProductDept->where('dept_id',1)->where('status','>', 0) as $item)
                         @if ($item->status == 4)
                         <a href="#!" title="Micro"><i class="ik ik-check f-16 mr-15 text-green"> <span style="font-size: 13">Micro</span></i></a>
                         @else
                         <a href="#!" title="Micro"><i class="ik ik-x  f-16 mr-15 text-red"><span style="font-size: 13">Micro</span></i></a>
                         @endif
                        @endforeach <br>

                        @foreach ($product->ProductDept->where('dept_id',2)->where('status','>', 0) as $item)
                         @if ($item->status == 8)
                         <a href="#!" title="Pharm"><i class="ik ik-check f-16 mr-15 text-green"><span style="font-size: 13">Pharm</span></i></a>
                         @else
                         <a href="#!" title="Pharm"><i class="ik ik-x  f-16 mr-15 text-red"></i><span style="font-size: 13">Pharm</span></a>
                         @endif
                        @endforeach <br>

                        @foreach ($product->ProductDept->where('dept_id',3)->where('status','>', 0) as $item)
                        @if ($item->status == 4)
                        <a href="#!" title="Phyto"><i class="ik ik-check f-16 mr-15 text-green"><span style="font-size: 13">Phyto</span></i></a>
                        @else
                        <a href="#!" title="Phyto"><i class="ik ik-x  f-16 mr-15 text-red"></i><span style="font-size: 13">Phyto</span></a>
                        @endif
                       @endforeach <br>

                    </td>
                    <td class="font">
                        @foreach ($product->ProductDept as $item)
                        <ul><li style="font-size:10px">  {{$item->created_at}}</li></ul>   
                        @endforeach
                    </td>
                    <td class="font">
                         <ul> 
                            <li style="font-size:10px">{{ucfirst( $product->micro_reportdatecompleted ? $product->micro_reportdatecompleted:'null')}}</li>
                            <li style="font-size:10px"> {{ucfirst( $product->phyto_reportdatecompleted ? $product->phyto_reportdatecompleted:'null')}}</li> 
                            <li style="font-size:10px"> {{ucfirst( $product->pharm_reportdatecompleted ? $product->pharm_reportdatecompleted:'null')}}</li> 
                        </ul>
                  </td>
                 
                    <td class="font">
                        <div class="form-check mx-sm-2">
                            <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input sidarchiveselect" name=""  value="{{$product->id}}" >
                                <span class="custom-control-label">&nbsp; </span>
                            </label>
                        </div>
                    </td>

                    </tr>
                   
                    @endforeach
                </tbody>
            </table>
              {{-- <select name="condition" id="">
                  <option value="">Reject Archived Report</option>
              </select>
              <button onclick="return confirm('Please comfirm selected items .')"  class="" type="submit"> Reject</button> --}}
            </form>

        </div>
    </div>
    </div>

    {{-- <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h3>All Completed Reports</h3></div>
            <div class="card-body">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th>Customer Details</th>
                            <th >Products</th>
                            <th>Tell</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $c)
                               
                        <tr>
                            <td style="width:30%">
                                <span> <strong>Customer Name:</strong> {{$c->name}}</span><br>
                                <span><strong>Company Name:</strong> {{$c->company_name}}</span><br>
                                <span> <strong>Company Address:</strong> {{$c->company_address}}</span><br>
                                <span> <strong>Company Tell:</strong> {{$c->company_phone}}</span><br>
                                <span> <strong>Customer Tell:</strong> {{$c->tell}}</span><br>

                            </td>
                            <td>
                                <div class="card">
                                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month{{$c->id}}" role="tab" aria-controls="pills-timeline" aria-selected="true">No of Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month{{$c->id}}" role="tab" aria-controls="pills-profile" aria-selected="false">Product Details</a>
                                        </li>
                                        
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="current-month{{$c->id}}" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                            <div class="card-body">
                                                  {{(count($c->product))}} Product(s)
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="last-month{{$c->id}}" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="card-body">
                                                @foreach ($c->product as $item)
                                                <ul>
                                                   <li style="font-size: 12px"><strong>Name:</strong>{{$item->name}} | <strong>Type:</strong>{{$item->productType->name}} | <strong>Date Received:</strong>{{$item->created_at->format('Y / m / d')}} 
                                                    @if ($item->archive == 1)
                                                    <strong>Status:</strong> <label class="badge badge-success">Completed</label>
                                                    @endif
                                                </li> <hr>
                                                </ul>
                                                 @endforeach
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </td> 
                            <td>
                                <div class="card-body">
                                   
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="#"><i class="ik ik-eye"></i></a>
                                    <a href="#"><i class="ik ik-edit-2"></i></a>
                                    <a href="#"><i class="ik ik-trash-2"></i></a>
                                </div>
                            </td>
                        </tr>
                       

                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}


@endsection