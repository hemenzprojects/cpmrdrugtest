@extends('admin.layout.main')

@section('content')
 
<div class="container-fluid">
          <div class="card">
          <div class="text-center"> 
            <h4 class="font" style="font-size:18px; margin-top:20px">List of Pending reports on {{\App\ProductType::find($ptype_id)->name}} </h4>
    
           </div>
           
        
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                <?php  $activetab = Session::get('activetab');
                if($activetab==null){
                    $activetab = 0;
                }
             ?>
                @for ($i = 0; $i < count($dept); $i++) 
                <li class="nav-item">
                <a class="nav-link {{ $i == $activetab ? 'active' : '' }}" id="pills-timeline-tab" data-toggle="pill" href="#tab{{ $i }}" role="tab" aria-controls="pills-timeline" aria-selected="false">{{$dept[$i]->name}}</a>
                </li>
                @endfor
            </ul>
            @for ($n = 0; $n < count($dept); $n++)
         
               
             @endfor
                 <div class="tab-content" id="pills-tabContent">
               
               
                        @for ($j = 0; $j < count($dept); $j++)
        
                        <div class="tab-pane fade {{$activetab==$j ? 'active show' : ''}}" id="tab{{$j}}" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                <div class="card-body">
                                    {{-- Lad Dept --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <a data-toggle="modal" data-target="#exampleModal{{$j}}">
                                                                        <div class="page-header">
                                                                            <div class="col-md-6">
                                                                                <div class="page-header-title">
                                                                                        <i class="ik ik-edit bg-blue"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <h5>{{$dept[$j]->name}}</h5>
                                                                            </div>
                                                                        </div>
                                                                </a>                                           
                                                            </div> 
                                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$j}}" data-whatever="@mdo">Open modal for @mdo</button> --}}
                                                    </div>  
                                                
                                                <table id="order-table{{$j}}" class="table table-striped table-bordered nowrap dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Code</th>
                                                                <th>Product Name</th>
                                                                <th>Quantity</th>
                                                                <th>status</th>
                                                                <th class="showstatus"></th>
                                                                <th>Distributed by</th>
                                                                <th>Received by</th>
                                                                <th>Actions</th>                        
                                                        </tr>
                                                        </thead>
                                                        <tbody>                                            
                                                            @foreach($dept[$j]->products()->whereIn('product_id',$pending)->where('overall_status','!=',2)->with('departments')->orderBy('status')->get() as $product)
                                                            <tr style="">
                                                                    <td class="font">
                                                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                                            {{$product->code}}
                                                                        </span>
                                                                    </td>
                                                                    <td class="font">{{ucfirst($product->name)}}
                                                                        @if ($product->failed_tag)
                                                                        <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">#R</span></sup>
                                                                        @endif
                                                                        @if($product->single_multiple_lab ==1)
                                                                        <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#S</span></sup>
                                                                        @endif
                                                                        @if($product->single_multiple_lab ==2)
                                                                        <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#M</span></sup>
                                                                        @endif
                                                                    </td>
                                                                    <td class="font">{{$product->pivot->quantity}}</td>
                                                                      <td class="font">{!! $product->product_status !!}</td>
                                                                    <td class="showstatus"><span style="display: none">{{$product->pivot->status}}</span></td>
                                                                    <td class="font">{{\App\Admin::find($product->pivot->distributed_by)?\App\Admin::find($product->pivot->distributed_by)->full_name:'null'}}</td>
                                                                    <td class="font">{{\App\Admin::find($product->pivot->received_by)?\App\Admin::find($product->pivot->received_by)->full_name:'null'}}</td>
                                                                                            
                                                                <td>
                                                                    <div class="table-actions">
                                                                                                            
                                                                    <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$j}}{{$product->id}}" title="View" href="{{$j}}{{$product->id}}"><i class="ik ik-eye"></i></a>
                                                                    <a title="Edit" href=""><i class="ik ik-edit"></i></a>
                                                                    @if ($product->pivot->status == '1')
                                                                    <a onclick="return confirm('Note! This action will delete selected category ?')" href="{{route('admin.sid.distributed_product.delete', ['id' => $product->id,'dept_id' =>$dept[$j]->id,'activetab'=>$j])}}"><i class="ik ik-trash-2"></i></a>
                                                                    @endif
                                                                </div>
                                                                
                                                                </td>
                                                        </tr>
                                                        <div class="modal fade" id="demoModal{{$j}}{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="demoModalLabel">{{App\Department::find($product->pivot->dept_id)->name}} Product Details of <span style="color: red">{{$product->code}} </span></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    
                                                                        <div class="card-body"> 
                                                                            
                                                                            <h6> Product Name </h6>
                                                                            <small class="text-muted ">{{$product->code}} |   {{ucfirst($product->name)}}</small>
                                                                            <h6>Product Type </h6>
                                                                            <small class="text-muted ">{{ucfirst($product->productType->name)}}</small>
                                                                            <h6>Quantity</h6>
                                                                            <small class="text-muted "> {{$product->pivot->quantity}}</small>
                                                                            <h6>Indication</h6>
                                                                            <p class="text-muted"> {{ ucfirst($product->indication)}}<br></p>
                                                
                                                                            <hr><h5>Distribution Details</h5>
                                                                            <h6>Received By </h6>
                                                                            <small class="text-muted">{{\App\Admin::find($product->pivot->received_by)?\App\Admin::find($product->pivot->received_by)->full_name:'null'}}</small>
                                                                            <h6>Distributed By </h6>
                                                                            <small class="text-muted">{{\App\Admin::find($product->pivot->distributed_by)?\App\Admin::find($product->pivot->distributed_by)->full_name:'null'}}</small>
                                                                            <h6>Delivered By </h6>
                                                                            <small class="text-muted">{{\App\Admin::find($product->pivot->delivered_by)?\App\Admin::find($product->pivot->delivered_by)->full_name:'null'}}</small>
        
                                                
                                                                            <hr><h5>Distribution Periods</h5>
                                                                            <div  style="margin-bottom: 5px">
                                                                            <h6 >product distribution period</h6>
                                                                            <small class="text-muted">
                                                                            Date: {{$product->pivot->created_at->format('Y-m-d')}}
                                                                            Time: {{$product->pivot->created_at->format('H:i:s')}}
                                                                            </small>
                                                                            </div>
                                                                            <h6> product delivery period</h6>
                                                                            <small class="text-muted ">
                                                                            Date: {{$product->pivot->updated_at->format('Y-m-d')}}
                                                                            Time: {{$product->pivot->updated_at->format('H:i:s')}}
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                 </div>
                        </div>
                    
               @endfor

                        <div class="card">
                            <div class="text-center"> 
                                <h4 class="font" style="font-size:18px; margin-top:20px">Summary of pending reports on {{\App\ProductType::find($ptype_id)->name}} </h4>
                        
                               </div>
                            <div class="card-body">
                                <div class="dt-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>status</th>

                                          
                                        </tr>
                                        </thead>
                                        <tbody>
                                           
                                            @foreach ($pending_overview as $item)
                                            <tr>
                                            <td class="font">
                                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                    {{$item->code}}
                                                </span>
                                            </td>
                                            <td>{{$item->name}}</td>
                                            <td class="font">
                                                @foreach ($item->departments as $dept)
                                                   <ul>
                                                       <li> {{$dept->name}}</li>
                                                   </ul>
                                                @endforeach
                                            </td>
                                            <td class="font">
                                                @foreach ($item->departments as $dept)
                                                   <ul>
                                                       <li> {!! $dept->product_status !!}</li>
                                                   </ul>
                                                @endforeach
                                            </td>
                                           </tr> 
                                           
                                            @endforeach
                                           
                                        </tbody>
                                    
                                    </table>
                                </div>
                         </div>
                        </div>
@endsection