<?php 
$product = \App\Product::find($report_id); 

?>
<div class="table-responsive">
    <table class="table table-striped table-bordered nowrap dataTable" >
        <thead>
            <tr  class="table-warning">
                <th>Product Code</th>
                <th>Product Form</th>
                <th>Date Received</th>
                <th>Date Analysed</th>
            </tr>
        </thead>
        <tbody>
           
              <tr>
                  <td class="font"> {{$product->code}}</td>
                  <td class="font"> {{$product->productType->name}}</td>
                  <td class="font">  
                    {!! $product->micro_date_received !!}  
                  <input class="form-control" required="required" type="date" placeholder="Date" name="date_received" value="{{($product->departmentById(1)->pivot->received_at)}}">                                     
                
                </td>
                  <td class="font">
                      <span> {!! $product->micro_analysed_date !!}
                    </span>
                    <input class="form-control" required="required" type="date" placeholder="Date" name="date_analysed" value="{{$product->micro_dateanalysed}}">
                    
                   </td>
                   <input type="hidden" name="micro_product_id" value="{{$product->id}}">
                   <input type="hidden" id="product_typestate" value="7777{{$product->productType->state}}">
                   @foreach ($show_productdept as $showproduct)  
                   <input class="form-control" type="hidden" id="product_status" value="811920012{{$showproduct->status}}">
                   @endforeach
              </tr>
          
        </tbody>
    </table>
</div>
