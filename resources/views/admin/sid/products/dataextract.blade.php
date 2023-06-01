<style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    
    tr:nth-child(even) {
      background-color: #dddddd;
    }
    </style>

<div class="col-md-12" style="overflow-x: scroll" >
                                  

    <table  >
       <thead>
           <tr>
               <th></th>
               <th>Code</th>
               <th  style="width:50px">Product Name</th>
               <th>Product Type</th>
               {{-- <th>Customer</th>
               <th>Amt Paid</th> --}}
               {{-- <th>Created By</th> --}}
               <th>Micro</th>
               <th>Pharm</th>
               <th>Phyto</th>
               <th>Date</th>
               

               
               {{-- <th>Actions</th> --}}
               
          </tr>
       </thead>
       <tbody >                                                
           @foreach($products->sortBy('id') as $product)
           <tr>
           <td><p  style="display: none">{{$product->id}}</p></td>
           <td class="font">
            {{$product->code}} 
        
          </td>
           <td class="font" style="width:15%">
               {{ucfirst($product->name)}}
         
           </td>
           <td class="font" >{{$product->productType->name}}</td>
           <td class="font" >
            @if($product->micro_grade ==1)
            <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">Failed</span></sup>
            @endif
            @if($product->micro_grade ==2)
            <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">Passed</span></sup>
            @endif
            </td>
           <td class="font" >
            @if($product->pharm_grade ==1)
            <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">Failed</span></sup>
            @endif
            @if($product->pharm_grade ==2)
            <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">Passed</span></sup>
            @endif
           </td>
           <td class="font" >
            @if($product->phyto_grade ==1)
            <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">Failed</span></sup>
            @endif
            @if($product->phyto_grade ==2)
            <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">Passed</span></sup>
            @endif
           </td>


          
           {{-- <td class="font">{{ucfirst($product->created_by)}}</td> --}}
           <td class="font">{{$product->created_at->format('Y / m / d')}}</td>
       

           </tr>
      
           @endforeach
       </tbody>
   </table>

</div>