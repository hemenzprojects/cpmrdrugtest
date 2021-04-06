@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card task-board">
            <div class="card-header" style="border-color: #f5365c;" >
                @foreach($phytoproducts->groupBy('product_id') as $phytoproduct)
                <label class="badge badge-warning" style="background-color:#f5365c; margin-right:5px;">
                   {{count($phytoproduct)}} 
                </label>
                @endforeach
                <h3>Tasks</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
              <span class="" style="padding:5px">
                <input class="form-control" id="listSearch1" type="text" placeholder="Type something to search list items">
              </span>
                
            <div class="card-body todo-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                <div class="dd" data-plugin="nestable" >
                    <ul class="list-group" id="myList1">
                        @foreach($phytoproducts as $phytoproduct)
                        <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                        <div class="dd-handle">
                            <div class="row align-items-center">
                                <div class="col-lg-10 col-md-12">
                                    <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                        {{$phytoproduct->code}}
                                    </span>  
                                </div> 
                                <div class="col-lg-2 col-md-12">
                                       <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$phytoproduct->id}}" title="View Product" href=""><i class="ik ik-eye"></i></a>   
                                </div>                                                           
                                
                            </div>  
                             
                        </div>
                        </li>
                        <div class="modal fade" id="demoModal{{$phytoproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="demoModalLabel"> Microbiology Product Details </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="card-body"> 
                                
                                        <h6> Product Name </h6>
                                        <small class="text-muted ">{{$phytoproduct->code}}</small>
                                        <h6>Product Type </h6>
                                        <small class="text-muted ">{{ucfirst($phytoproduct->productType->name)}}</small>
                                        <h6>Quantity</h6>
                                        @foreach ($phytoproduct->departments->where('id',1) as $product)
                                        <small class="text-muted ">{{$product->pivot->quantity}}</small>
                                        @endforeach
                                        <small class="text-muted "></small>
                                        <h6>Indication</h6>
                                        <p class="text-muted"> {{ ucfirst($phytoproduct->indication)}}<br></p>

                                        <hr><h5>Distribution Details</h5>
                                        <h6>Received By </h6>
                                        @foreach ($phytoproduct->departments->where('id',1) as $product)
                                        <small class="text-muted">{{\App\Admin::find($product->pivot->received_by)? \App\Admin::find($product->pivot->received_by)->full_name:'null'}}</small>
                                        @endforeach
                                        <h6>Distributed By </h6>
                                        @foreach ($phytoproduct->departments->where('id',1) as $product)
                                        <small class="text-muted">{{\App\Admin::find($product->pivot->distributed_by)?\App\Admin::find($product->pivot->distributed_by)->full_name:'null'}}</small>
                                        @endforeach
                                        <h6>Delivered By </h6>
                                        @foreach ($phytoproduct->departments->where('id',1) as $product)
                                        <small class="text-muted">{{\App\Admin::find($product->pivot->delivered_by)?\App\Admin::find($product->pivot->delivered_by)->full_name:'null'}}</small>
                                        @endforeach
                                     
                                        {{-- <hr><h5>Customer Details</h5>
                                        
                                        <h6>Name</h6>
                                        <small class="text-muted ">{{ucfirst($phytoproduct->customer->name)}}</small>
                                        <h6>Tell</h6>
                                        <small class="text-muted ">{{ucfirst($phytoproduct->customer->tell)}}</small>
                                         --}}
                                        <hr><h5>Distribution Periods</h5>
                                        <div  style="margin-bottom: 5px">
                                        <h6 >product distribution period</h6>
                                            <small class="text-muted">
                                            @foreach ($phytoproduct->departments as $product)
                                            Date: <small class="text-muted ">{{$product->pivot->created_at->format('Y-m-d')}}</small>
                                            Time: <small class="text-muted ">{{$product->pivot->created_at->format('H:i:s')}}</small>
                                            @endforeach
                                        </small>
                                        </div>
                                        <h6> product delivery period</h6>
                                        <small class="text-muted ">
                                            @foreach ($phytoproduct->departments as $product)
                                            Date: <small class="text-muted ">{{$product->pivot->updated_at->format('Y-m-d')}}</small>
                                            Time: <small class="text-muted ">{{$product->pivot->updated_at->format('H:i:s')}}</small>
                                            @endforeach
                                        
                                        </small>
                                    </div> 
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header" style="border-color: #f7ca18;" >
                
                @if (count($auth) >0)
                @if ($auth_id->user_type_id >3)
                @foreach($auth_phytoreports->groupBy('product_id') as $phytoreport)
                <label class="badge badge-warning" style="background-color:#f7ca18; margin-right:5px;">
                   {{count($phytoreport)}} 
                </label>
                @endforeach
                @endif
                @endif
                
                @if (count($auth) >0)
                @if ($auth_id->user_type_id < 4)
                @foreach($phytoreports->groupBy('product_id') as $phytoreport)
                <label class="badge badge-warning" style="background-color:#f7ca18; margin-right:5px;">
                   {{count($phytoreport)}} 
                </label>
                @endforeach
                @endif
                @endif
              
                
                <h3>In Progress</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
            <span class="" style="padding:5px">
                <input class="form-control" id="listSearch2" type="text" placeholder="Type something to search list items">
            </span>
            <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                <div class="dd" data-plugin="nestable">
                    <ul class="dd-list" id="myList2">
                        @if (count($auth) >0)
                        @if ($auth_id->user_type_id < 4)
                        @foreach($phytoreports->sortBy('phyto_hod_evaluation') as $phytoreport)
                        <li class="dd-item" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">
                                    <div class="col-lg-10 col-md-12">
                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                            {{$phytoreport->code}}
                                        </span>  

                                            <span>

                                             <span class=" font">
                                                       
                                                <small class="float-right font"><strong>Assigned: </strong>
                                                    <span style="font-size: 10px; margin:2px">        
                                                    {{\App\Admin::find($phytoreport->phyto_analysed_by)? \App\Admin::find($phytoreport->phyto_analysed_by)->full_name:' null '}}
                                                    </span>
                                                </small><br>
                                                <small class="float-right font"><strong>Approval 1: </strong>
                                                    <span style="font-size: 10px;margin:2px"> 
                                                    {{\App\Admin::find($phytoreport->phyto_approved_by)? \App\Admin::find($phytoreport->phyto_approved_by)->full_name:' null '}}
                                                    </span>
                                                </small><br>
                                                <small class="float-right font"><strong>Approval 2: </strong>
                                                    <span style="font-size: 10px;margin:2px"> 
                                                    {{\App\Admin::find($phytoreport->phyto_finalapproved_by)? \App\Admin::find($phytoreport->phyto_finalapproved_by)->full_name:' null '}}
                                                    </span>
                                                </small>
                                                </span><br><br>

                                          <span><strong>Evaluation:</strong> 
                                           {!! $phytoreport->phyto_report_evaluation !!}
                                          </span><br>
                                          <span><strong>Created at:</strong> 
                                           <sup style="font-size: 10px">  @foreach($phytoreport->organolipticReport as $temp)
                                            @if($phytoreport->organolipticReport->first() == $temp)
                                            {{$temp->created_at->format('d/m/y')}}
                                            @endif
                                            @endforeach</sup>
                                            
                                            </span>
                                            <span class="float-right font">
                                                <a onclick="return confirm('Are you sure of deleting record?')" href="{{route('admin.phyto.report.delete',['id' =>$phytoreport->id ])}}">
                                                  <i style="color: rgb(200, 8, 8)" class="ik ik-trash-2"> delete </i>
                                                </a>
                                                 
                                            </span>
                                    </div> 
                                    <div class="col-lg-2 col-md-12">
                                    <a href="{{url('admin/phyto/makereport/show',['id'=>$phytoreport->id])}}"><i class="ik ik-eye"></i></a> 
                                      
                                    </div>                                                           
                                    
                                </div>  
                            </div>
                        </li>
                         @endforeach
                         @endif
                         @endif


                         @if (count($auth) >0)
                         @if ($auth_id->user_type_id >3)
                         @foreach($auth_phytoreports->sortBy('phyto_hod_evaluation') as $phytoreport)
                         <li class="dd-item" data-id="1">
                             <div class="dd-handle">
                                 <div class="row align-items-center">
                                     <div class="col-lg-10 col-md-12">
                                         <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                             {{$phytoreport->code}}
                                         </span>  
 
                                             <span>
 
                                              <span class=" font">
                                                        
                                                 <small class="float-right font"><strong>Assigned: </strong>
                                                     <span style="font-size: 10px; margin:2px">        
                                                     {{\App\Admin::find($phytoreport->phyto_analysed_by)? \App\Admin::find($phytoreport->phyto_analysed_by)->full_name:' null '}}
                                                     </span>
                                                 </small><br>
                                                 <small class="float-right font"><strong>Approval 1: </strong>
                                                     <span style="font-size: 10px;margin:2px"> 
                                                     {{\App\Admin::find($phytoreport->phyto_approved_by)? \App\Admin::find($phytoreport->phyto_approved_by)->full_name:' null '}}
                                                     </span>
                                                 </small><br>
                                                 <small class="float-right font"><strong>Approval 2: </strong>
                                                     <span style="font-size: 10px;margin:2px"> 
                                                     {{\App\Admin::find($phytoreport->phyto_finalapproved_by)? \App\Admin::find($phytoreport->phyto_finalapproved_by)->full_name:' null '}}
                                                     </span>
                                                 </small>
                                                 </span><br><br>
 
                                           <span><strong>Evaluation:</strong> 
                                            {!! $phytoreport->phyto_report_evaluation !!}
                                           </span><br>
                                           <span><strong>Created at:</strong> 
                                            <sup style="font-size: 10px">  @foreach($phytoreport->organolipticReport as $temp)
                                             @if($phytoreport->organolipticReport->first() == $temp)
                                             {{$temp->created_at->format('d/m/y')}}
                                             @endif
                                             @endforeach</sup>
                                             
                                             </span>
                                             <span class="float-right font">
                                                 <a onclick="return confirm('Are you sure of deleting record?')" href="{{route('admin.phyto.report.delete',['id' =>$phytoreport->id ])}}">
                                                   <i style="color: rgb(200, 8, 8)" class="ik ik-trash-2"> delete </i>
                                                 </a>
                                                  
                                             </span>
                                     </div> 
                                     <div class="col-lg-2 col-md-12">
                                     <a href="{{url('admin/phyto/makereport/show',['id'=>$phytoreport->id])}}"><i class="ik ik-eye"></i></a> 
                                       
                                     </div>                                                           
                                     
                                 </div>  
                             </div>
                         </li>
                          @endforeach
                          @endif
                          @endif

                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                @foreach($phytocompleted_reports->groupBy('product_id') as $phytocompleted_report)
                <label class="badge badge-warning" style="background-color:#26c281; margin-right:5px;">
                   {{count($phytocompleted_report)}} 
                </label>
                @endforeach
                <h3>Completed</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
            <span class="" style="padding:5px">
                <input class="form-control" id="listSearch3" type="text" placeholder="Type something to search list items">
            </span>
            <div class="card-body completed-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                <div class="dd" data-plugin="nestable">
                    <ul class="dd-list" id="myList3">                                   
                        @foreach($phytocompleted_reports as $phytocompeleted_report)
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <div class="row align-items-center">
                                        <div class="col-lg-10 col-md-12">
                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                {{$phytocompeleted_report->code}}
                                            </span>  

                                                <span>
                                                <small class=" font">
                                                    <strong>Assigned:</strong>{{\App\Admin::find($phytocompeleted_report->phyto_analysed_by)? \App\Admin::find($phytocompeleted_report->phyto_analysed_by)->full_name:'null'}}</small><br>
                                                </span>

                                            <span><strong>Evaluation:</strong> 
                                            {!! $phytocompeleted_report->phyto_report_evaluation !!}
                                            </span>
                                           
    

                                        </div> 
                                        <div class="col-lg-2 col-md-12">
                                        <a href="{{url('admin/phyto/completedreport/show',['id'=>$phytocompeleted_report->id])}}"><i class="ik ik-eye"></i></a>   
                                        </div>                                                           
                                        
                                    </div>  
                                    <span class="float-right font" style="margin-top:10px">
                                        <a href="{{route('admin.phyto.report.pdf',['id' => $phytocompeleted_report->id])}}">
                                            <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                          </a>
                                           
                                      </span>
                                </div>
                            </li>
                       @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


 <div class="card" style=" margin-bottom:7%">
        <ul class="nav justify-content-center" style="margin-top: 10px"> 
        <h5>TECHNICAL INFORMATION </h5>
        </ul>
      <div class="card-body">
          
        <form action="{{url('admin/phyto/makereport/create')}}" method="post">
            {{ csrf_field() }}
           <div class="row">
               <div class="col-md-3"></div>
               <div class="col-md-6" style="margin-top: 1%;margin-bottom: 2%">
                <div class="form-group">
                    <ul class="nav justify-content-center" style="margin-top: 10px"> 
                        <label for="">Select Product</label>
                        </ul>
                    <select required class="form-control select2" name="product_id">
                        @foreach($phytoproducts as $phytoproduct)
                       <option value="{{$phytoproduct->id}}" style="font-size: 2px">{{$phytoproduct->code}} </option>
                  
                        @endforeach
                    </select>
                </div>
               </div>
               <div class="col-md-3"></div>
                <div class="col-md-12">
                    <h6>A. {{\App\PhytoTestConducted::find(1)->name}}</h6>
                    <input type="hidden" name="phyto_testconducted_1" value="{{\App\PhytoTestConducted::find(1)->id}}">
                    <table class="table table-inverse">                      
                        <tbody>
                            @foreach ($phyto_organoleptics_admin as $organo_item)
                            <tr>
                            <th>
                                <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input select_all_child" id="" name="organoleptics_id[]" value="{{$organo_item->id}}">
                                <span class="custom-control-label">&nbsp;</span>
                               </label>
                           </th>
                            <td class="font">
                                <input type="text" class="form-control" name="organolepticsname_{{$organo_item->id}}" value="{{$organo_item->name}}">
                            </td>
                            

                            <td class="font"><input class="form-control" type="text" name="organolepticsfeature_{{$organo_item->id}}" value="{{$organo_item->feature}}"></td>
                            <td>
                                <select name="organolepticsroworder_{{$organo_item->id}}">
                                     @foreach ($phyto_organoleptics_admin as $item)
                                     <option value="{{$item->id}}" {{$item->id == $organo_item->id ? "selected":""}}>Row {{$item->id}}</option>
                                     @endforeach
                                </select>
                            </td>
                          </tr>        
                            @endforeach
                       </tbody>
                    </table>
                       
                </div>

                  <div class="col-md-12">
                        <h6>B. {{\App\PhytoTestConducted::find(2)->name}}</h6>
                    <input type="hidden" name="phyto_testconducted_2" value="{{\App\PhytoTestConducted::find(2)->id}}">

                        <table class="table table-inverse">                      
                            <tbody>
                                @for ($i = 0; $i < count($phyto_physicochemdata_admin); $i++)
                                    
                             
                                <tr>
                                <th>
                                       <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input select_all_child" id="" name="physicochemdata_id[]" value="{{$phyto_physicochemdata_admin[$i]->id}}">
                                        <span class="custom-control-label">&nbsp;</span>
                                     
                                       </label>
                               </th>
                                <td class="font" style="width:"> 


                                {{-- <span class="physicochem_{{$phyto_physicochemdata_admin[$i]->id}}">
                                    {{$phyto_physicochemdata_admin[$i]->name}}
                                </span> --}}
                                {{-- type="{{$phyto_physicochemdata_admin[$i]->id != 1 && $phyto_physicochemdata_admin[$i]->id != 2 && $phyto_physicochemdata_admin[$i]->id != 4 ?'hidden':''}}" --}}
                                    <input class="form-control"  name="physicochemname_{{$phyto_physicochemdata_admin[$i]->id}}" value="{{$phyto_physicochemdata_admin[$i]->name}}">
                                </td>
                                {{-- <input type="hidden" name="physicochemname_{{$physicochem_item->id}}" value="{{$physicochem_item->name}}"> --}}
                                <td class="font" style="width:30%">
                                   <input type="hidden" name="physicochemdata_location_{{$phyto_physicochemdata_admin[$i]->id}}" value="{{$phyto_physicochemdata_admin[$i]->location}}">
                                  
                                    <input class="form-control" type="text" name="physicochemresult_{{$phyto_physicochemdata_admin[$i]->id}}" value="{{$phyto_physicochemdata_admin[$i]->result}}">
                                </td>
                                <td class="font">
                                
                                    <input class="form-control" type="text"  name="physicochemunit_{{$phyto_physicochemdata_admin[$i]->id}}" value="{{$phyto_physicochemdata_admin[$i]->unit}}" {{$phyto_physicochemdata_admin[$i]->location == 1 ? "readonly" : "" }}>

                                </td>
                                <td>
                                    <select name="physicochemdata_roworder_{{$phyto_physicochemdata_admin[$i]->id}}" id="">
                                         @foreach ($phyto_physicochemdata_admin as $item)
                                         <option value="{{$item->id}}" {{$item->id == $phyto_physicochemdata_admin[$i]->id ? "selected":""}}>Row {{$item->id}}</option>
                                         @endforeach
                                    </select>
                                </td>
                                </tr>        
                                @endfor
                           </tbody>
                        </table>
                           
                  </div>

            </div>
            <div class="row" style="margin-top:5%; margin-bottom:3%">
                <div class="col-md-9">
                    <h6>C. {{\App\PhytoTestConducted::find(3)->name}}</h6>
                    <input type="hidden" name="phyto_testconducted_3" value="{{\App\PhytoTestConducted::find(3)->id}}">

                    <div class="form-group">
                        
                        <select class="form-control select2" name="chemicalconst[]" multiple="multiple">
                            <?php
                            $phytochem =1;
                            ?>
                            
                            @foreach ($phyto_chemicalconsts_admin as $item)
                           
                            <option value="{{$item->id}}" {{$phytochem == $item->id? "selected":""}}>{{$item->name}}</option>  
  
                            @endforeach
                          
                        </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                   
                  </div>
                  <div class="col-md-12">
                     
                    <h6 style="margin-top: 2%">REMARKS</h6>
                    <textarea class="form-control" name="comment" id="" cols="30" rows="3">The presence of the above mentioned phytochemical constituents indicates that the product may be planted-based. The pH of the product falls outside the acceptance range of 4.00 - 10.00. </textarea>

                 </div>

                  <div class="col-md-3">
                    <h6 style="margin-top: 5%">Date Analysed</h6>
                    <input type="text" class="form-control datetimepicker-input" name="date_analysed" data-date-format="DD-MM-YYYY" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" value="" placeholder=" {{Carbon\Carbon::now()->format('d/m/Y')}}" style="width:250px">


                   <h6 style="margin-top: 5%"></h6>
                   <button type="submit" onclick="return confirm('Are sure of report submition')" class="btn btn-primary mr-2">Submit Report</button>

                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                    <label for="exampleInputEmail3" style="margin-top: 5%"> <strong><span style="color: red">Report Evaluation</span></strong>  </label>
                    <select name="phyto_grade" required class="form-control" id="exampleSelectGender">
                    <option value="">None</option>
                        <option value="1">Failed</option>
                        <option value="2">Passed</option>
                    </select>                                
                    </div>
                 </div>
            </div>
        </form>
      </div>
  
 </div>

    <br><br>

</div>
@endsection