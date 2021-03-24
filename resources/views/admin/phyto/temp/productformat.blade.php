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
                                                 
                    {{ $product->departmentById(3)->pivot->updated_at->format('jS \\, F Y') }}                                        
                  </td>
                  <td class="font">
                      
                      <span> {{ Carbon\Carbon::parse($product->phyto_dateanalysed)->format('jS \\, F Y')}}
                    </span>
                    <input class="form-control"  type="date" placeholder="Date" name="date_analysed" value="{{$product->phyto_dateanalysed}}">
                   
                   </td>
              
              </tr>
          
        </tbody>
    </table>
</div>
