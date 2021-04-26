<tr style="background-color: #fff">
    <td class="font">
    <label class="custom-control custom-checkbox">
        <input type="checkbox" id="pharmproduct_{{$pharmproduct->id}}" product_method="{{$pharmproduct->productType->method_applied}}" name="product_id[]" class="custom-control-input method_applied" value="{{$pharmproduct->id}}">
        <span class="custom-control-label"></span>
    </label>
   </td>
    <td class="font">

    <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$pharmproduct->id}}" title="View Product" href="">
        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
            {{$pharmproduct->code}}
        </span>
    </a> 
  
    </td>
    <td class="font">
        <input type="text" class="form-control" name="weight_{{$pharmproduct->id}}"  placeholder="Weight" >
    </td>
    <td class="font">
        <input type="text" class="form-control" name="dosage_{{$pharmproduct->id}}"  placeholder="Dosage" value="{{$pharmproduct->dosage}}">
    </td>
    <td class="font">
        <input type="text" class="form-control" name="yield_{{$pharmproduct->id}}"  placeholder="Yield">
    </td>
    <td class="font">

        <select  name="pharm_testconducted_{{$pharmproduct->id}}" style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
            <option value="">Select Test</option>
            @foreach($pharm_testconducteds as $pharm_testconducted)
                                
            <option value="{{$pharm_testconducted->id}}" {{$pharm_testconducted->id == $pharmproduct->productType->method_applied ? "selected":""}}>{{$pharm_testconducted->name}}</option>
            
            @endforeach
            </select>
    </td>
    <td class="font">
        {{ $pharmproduct->departmentById(2)->pivot->received_at }}                                        

    </td>

</tr>
<div class="modal fade" id="demoModal{{$pharmproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel"> Microbiology Product Details </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="card-body"> 
        
                <h6> Product Name </h6>
                <small class="text-muted ">
                    <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                        {{$pharmproduct->code}}
                    </span>                                            </small>
                <h6>Product Type </h6>
                <small class="text-muted ">{{ucfirst($pharmproduct->productType->name)}}</small>
                <h6>Quantity</h6>                                         
                @foreach ($pharmproduct->departments->where('id',2) as $product)
                <small class="text-muted ">{{$product->pivot->quantity}}</small>
                @endforeach
                <small class="text-muted "></small>
                <h6>Indication</h6>
                <p class="text-muted"> {{ ucfirst($pharmproduct->indication)}}<br></p>

                <hr><h5>Distribution Details</h5>
                <h6>Received By </h6>
                @foreach ($pharmproduct->departments->where('id',2) as $product)
                <small class="text-muted">{{\App\Admin::find($product->pivot->received_by)? \App\Admin::find($product->pivot->received_by)->full_name:'null'}}</small>
                @endforeach
                <h6>Distributed By </h6>
                @foreach ($pharmproduct->departments->where('id',2) as $product)
                <small class="text-muted">{{\App\Admin::find($product->pivot->distributed_by)?\App\Admin::find($product->pivot->distributed_by)->full_name:'null'}}</small>
                @endforeach
                <h6>Delivered By </h6>
                @foreach ($pharmproduct->departments->where('id',2) as $product)
                <small class="text-muted">{{\App\Admin::find($product->pivot->delivered_by)?\App\Admin::find($product->pivot->delivered_by)->full_name:'null'}}</small>
                @endforeach
                


                <hr><h5>Distribution Periods</h5>
                <div  style="margin-bottom: 5px">
                <h6 >product distribution period</h6>
                    <small class="text-muted">
                    @foreach ($pharmproduct->departments as $product)
                    Date: <small class="text-muted ">{{$product->pivot->created_at->format('Y-m-d')}}</small>
                    Time: <small class="text-muted ">{{$product->pivot->created_at->format('H:i:s')}}</small>
                    @endforeach
                </small>
                </div>
                <h6> product delivery period</h6>
                <small class="text-muted ">
                    @foreach ($pharmproduct->departments as $product)
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