@extends('admin.layout.main')

@section('content')



<div class="card">
    <form  action="{{route('admin.pharm.animalexperiment.receive')}}" class="" method="POST">
        {{ csrf_field() }}
    <div class="card-header" >
        <h3>Receive Product for experimentation</h3>
    </div>
    <div class="card-body" style="overflow-x: scroll;">
        <div class="dt-responsive" >
           
            <table id="lang-dt"
                   class="table table-striped table-bordered nowrap">
                  Total Quantity: @foreach($sample_preps->groupBy('product_id') as $sample_prep)
                   <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                      {{count($sample_prep)}} 
                   </label>
                   @endforeach
                <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Measurement</th>
                    {{-- <th>Dosage</th>
                    <th>Yield</th> --}}
                    <th>Test to conduct</th>
                    <th>Delivery Officer</th>
                    <th>Received By</th>
                    <th>Date Distributed</th>
                    <th>Date Delivered</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($sample_preps as $sample_prep)
                 
                    @foreach ($sample_prep->samplePreparation as $product)
                    <tr style="background-color: #fff">
                        <td class="font">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="product_id[]" class="custom-control-input" value="{{$sample_prep->id}}">
                            <span class="custom-control-label"></span>
                        </label>
                       </td>
                        <td class="font">
                        <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$sample_prep->id}}" title="View Product" href="">
                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                {{$sample_prep->code}}
                            </span>
                        </a> 
                         
                        </td>
                        <td class="font">
                            {{$product->measurement}}
                        </td>
                    
                        <td class="font">
                            {{\App\PharmTestConducted::find($product->pharm_testconducted_id)->name}}
                        </td>
                        <td class="font">
                            {{\App\Admin::find($product->delivered_by)? \App\Admin::find($product->delivered_by)->full_name:'null'}}
                        </td> 
                        <td class="font">
                        {{\App\Admin::find($product->received_by)? \App\Admin::find($product->received_by)->full_name:'null'}}
                        </td> 
                        <td class="font">
                            {{ Carbon\Carbon::parse($product->updated_at)->format('jS \\, F Y')}}

                        </td> 
                        <td class="font">
                            {{Carbon\Carbon::parse($product->delivered_at)->format('jS \\, F Y')? $product->delivered_at:'null'}}
                        </td> 

                    </tr>
                    <div class="modal fade" id="demoModal{{$sample_prep->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="demoModalLabel"> Microbiology Product Details </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="card-body"> 
                            
                                    <h6> Product</h6>
                                    <small class="text-muted ">{{$sample_prep->productType->code}}|{{$sample_prep->id}}|{{$sample_prep->created_at->format('y')}} </small>
                                    <h6>Product Type </h6>
                                    <small class="text-muted ">{{ucfirst($sample_prep->productType->name)}}</small>
                                    <h6>Quantity</h6>                                         
                                    @foreach ($sample_prep->departments->groupBy('id')->first() as $product)
                                    <small class="text-muted ">{{$product->pivot->quantity}}</small>
                                    @endforeach
                                    <small class="text-muted "></small>
                                    <h6>Indication</h6>
                                    <p class="text-muted"> {{ ucfirst($sample_prep->indication)}}<br></p>

                                        @foreach ($sample_prep->samplePreparation as $product)
                                            <h6>Delivery Officer </h6>
                                            <small class="text-muted">{{\App\Admin::find($product->delivered_by)?\App\Admin::find($product->delivered_by)->full_name:'null'}}</small>
                                            <h6>Received By </h6>
                                            <small class="text-muted">{{\App\Admin::find($product->received_by)?\App\Admin::find($product->received_by)->full_name:'null'}}</small>
                                          
                                            @endforeach
                                            <hr><h5>Distribution Periods</h5>
                                            <div  style="margin-bottom: 5px">
                                            <p>
                                                <h6 >Distribution Period</h6>
                                                @foreach ($sample_prep->samplePreparation as $product)
                                                Date: <small class="text-muted ">{{$product->created_at->format('Y-m-d')}}</small>
                                                Time: <small class="text-muted ">{{$product->created_at->format('H:i:s')}}</small>
                                                @endforeach
                                            </p>
                                            <p>
                                                <h6 >Date Analysed</h6>

                                                @foreach ($sample_prep->samplePreparation as $product)
                                                Date: <small class="text-muted ">{{$product->updated_at->format('Y-m-d')}}</small>
                                                Time: <small class="text-muted ">{{$product->updated_at->format('H:i:s')}}</small>
                                                @endforeach
                                            </p>
                                            </div>

                                            <hr><h5>Preparation Details</h5>
                                            
                                            @foreach ($sample_prep->samplePreparation as $product)
                                            <p><strong>Volume/Mass/Weight :</strong> {{$product->measurement}} </p>
                                            <p><strong>Dosage :</strong> {{$product->dosage}} </p>
                                            <p><strong>Yield :</strong> {{$product->yield}} </p>
                                            <p><strong>Remarks :</strong> {{$product->remarks}} </p>

                                            @endforeach
                                </div> 
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                   @endforeach
                    @endforeach
             </tbody>
            
            </table>
        </div>

        <div class="row" style="margin-top:5px">
            <div class="col-md-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <select required="" name="status" class="form-control" id="exampleSelectGender">
                       <option value=""> Select Status</option>                                        
                        {{-- <option value="1">Reject</option> --}}
                        <option value="2">Receive</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">   
                <button onclick="return confirm('Please click Ok to confirm received product/(s)')" type="submit" class="btn btn-primary mb-2">Receive Selected Product</button>
            </div>
            <div class="col-md-4">   
                <select required name="officer" style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value="">Select Staff</option>
                    @foreach(\App\Admin::where('dept_id',2)->where('dept_office_id','<',3)->get() as $officer)
                                    
                    <option  value="{{$officer->id}}" {{$officer->id == old('admin')? "selected":""}}>{{$officer->full_name}}</option>

                    @endforeach
                </select>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection