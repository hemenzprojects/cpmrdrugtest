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
                <h3>Todos</h3>
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
                                    <p><span href="" class="badge badge-danger pull-right">
                                    {{$phytoproduct->productType->code}}|{{$phytoproduct->id}}|{{$phytoproduct->created_at->format('y')}}
                                    </span>
                                      <span>
                                        <sup style="font-size: 1px">
                                            {{$phytoproduct->productType->code}}{{$phytoproduct->id}}{{$phytoproduct->created_at->format('y')}}
                                         </sup> 
                                      </span>
                                    </p>
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
                                        <small class="text-muted ">{{$phytoproduct->productType->code}}|{{$phytoproduct->id}}|{{$phytoproduct->created_at->format('y')}} </small>
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
                @foreach($phytoreports->groupBy('product_id') as $phytoreport)
                <label class="badge badge-warning" style="background-color:#f7ca18; margin-right:5px;">
                   {{count($phytoreport)}} 
                </label>
                @endforeach
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
                        @foreach($phytoreports->sortBy('phyto_hod_evaluation') as $phytoreport)
                        <li class="dd-item" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">
                                    <div class="col-lg-10 col-md-12">
                                            <p><span href="" class="badge badge-warning pull-right">
                                            {{$phytoreport->productType->code}}|{{$phytoreport->id}}|{{$phytoreport->created_at->format('y')}}
                                            </span>
                                            <sup style="font-size: 1px">
                                                {{$phytoreport->productType->code}}{{$phytoreport->id}}{{$phytoreport->created_at->format('y')}}
                                             </sup> 
                                            </p>

                                            <span>
                                            <small class=" font">
                                                <strong>Assigned: </strong>{{\App\Admin::find($phytoreport->phyto_analysed_by)? \App\Admin::find($phytoreport->phyto_analysed_by)->full_name:'null'}}</small><br>
                                             </span>

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
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
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
                                                <p><span href="" class="badge badge-warning pull-right">
                                                {{$phytocompeleted_report->productType->code}}|{{$phytocompeleted_report->id}}|{{$phytocompeleted_report->created_at->format('y')}}
                                                </span>
                                                <sup style="font-size: 1px">
                                                    {{$phytocompeleted_report->productType->code}}{{$phytocompeleted_report->id}}{{$phytocompeleted_report->created_at->format('y')}}
                                                 </sup> 
                                                </p>

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
                    <select  class="form-control select2" name="product_id">
                        @foreach($phytoproducts as $phytoproduct)
                       <option value="{{$phytoproduct->id}}" style="font-size: 2px">{{$phytoproduct->productType->code}}-{{$phytoproduct->id}}-{{$phytoproduct->created_at->format('y')}} </option>
                  
                        @endforeach
                    </select>
                </div>
               </div>
               <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h6>A. {{\App\PhytoTestConducted::find(1)->name}}</h6>
                    <input type="hidden" name="phyto_testconducted_1" value="{{\App\PhytoTestConducted::find(1)->id}}">
                    <table class="table table-inverse">                      
                        <tbody>
                            @foreach ($phyto_organoleptics->where('action',1) as $organo_item)
                            <tr>
                            <th>
                                <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input select_all_child" id="" name="organoleptics_id[]" value="{{$organo_item->id}}">
                                <span class="custom-control-label">&nbsp;</span>
                               </label>
                           </th>
                            <td class="font">{{$organo_item->name}} :</td>
                            
                            <input type="hidden" name="organolepticsname_{{$organo_item->id}}" value="{{$organo_item->name}}">

                            <td class="font"><input class="form-control" type="text" name="organolepticsfeature_{{$organo_item->id}}" value="{{$organo_item->feature}}"></td>
                            </tr>        
                            @endforeach
                       </tbody>
                    </table>
                       
                </div>

                  <div class="col-md-6">
                        <h6>B. {{\App\PhytoTestConducted::find(2)->name}}</h6>
                    <input type="hidden" name="phyto_testconducted_2" value="{{\App\PhytoTestConducted::find(2)->id}}">

                        <table class="table table-inverse">                      
                            <tbody>
                                @foreach ($phyto_physicochemdata->where('action',1) as $physicochem_item)
                                <tr>
                                <th>
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select_all_child" id="" name="physicochemdata_id[]" value="{{$physicochem_item->id}}">
                                    <span class="custom-control-label">&nbsp;</span>
                                   </label>
                               </th>
                                <td class="font"> 
                                <p class="physicochem_{{$physicochem_item->id}}">{{$physicochem_item->name}}</p>
                                    <input class="form-control" type="{{$physicochem_item->id != 4?'hidden':''}}" name="physicochemname_{{$physicochem_item->id}}" value="{{$physicochem_item->name}}">
                                </td>
                                {{-- <input type="hidden" name="physicochemname_{{$physicochem_item->id}}" value="{{$physicochem_item->name}}"> --}}
                                <td class="font"><input class="form-control" type="text" name="physicochemresult_{{$physicochem_item->id}}" value="{{$physicochem_item->result}}"></td>
                                </tr>        
                                @endforeach
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
                            @foreach ($phyto_chemicalconst->where('action',1) as $item)
                           
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

                  <div class="col-md-6">
                    <h6 style="margin-top: 2%">Date Analysed</h6>
                   <input type="date" required class="form-control" name="date_analysed">

                   <h6 style="margin-top: 5%"></h6>
                   <button type="submit" onclick="return confirm('Are sure of report submition')" class="btn btn-primary mr-2">Submit Report</button>

                    </div>
            </div>
        </form>
      </div>
  
 </div>

    <br><br>

</div>
@endsection