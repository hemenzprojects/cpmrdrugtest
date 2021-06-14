<?php 
$product = \App\Product::find($report_id); 

?>

<div class="table-responsive">
    <table class="table table-striped table-bordered nowrap dataTable" >
        <thead>
            <tr  class="table-warning">
                <th>Product Code</th>
                <th>Dosage Form</th>
                <th>Date Received</th>
                <th>Date Analysed</th>
            </tr>
        </thead>
        <tbody>
            
              <tr>
                  <td class="font"> {{$product->code}}</td>
                  <td class="font"> {{$product->productType->name}}</td>
                  <td class="font">  
                    {!! $product->phyto_date_received !!}      
                    <input class="form-control" required="required" type="date" placeholder="Date" name="date_received" value="{{($product->departmentById(3)->pivot->received_at)}}">                                     
                  </td>
                  <td class="font">
                      
                      <span> {!! $product->phyto_analysed_date !!}
                    </span>
                    <input class="form-control"  type="date" placeholder="Date" name="date_analysed" value="{{$product->phyto_dateanalysed}}">
                   
                   </td>
              
              </tr>
          
        </tbody>
    </table>
</div>
