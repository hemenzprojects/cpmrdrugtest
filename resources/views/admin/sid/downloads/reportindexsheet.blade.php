<html>
    <head>
        <style>
            .font{
                  font-size: 12px;
                }
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
              background-color:#dddddd6b;
            }
            .center {
              display: block;
              margin-left: auto;
              margin-right: auto;
              width: 10%;
              margin-bottom: 5px
            }
            .title {
              display: block;
              margin-left: auto;
              margin-right: auto;
              margin-bottom: 5px;
              font-size: 18px;
            }
            .myDiv {
                text-align: center;
                margin-top: -25px;
            }
            
            .watermarked1{
                background-image: url('{{ asset('admin/img/logo.jpg')}}');
                background-size: 60% 50%;
                background-position: center;
                background-repeat: no-repeat;
            }
            .watermarked2{
                background-image: url('{{ asset('admin/img/logo.jpg')}}');
                background-size: 68% 50%;
                background-position: center;
                background-repeat: no-repeat;
            }
            
            .footer{
              margin-top: 0%;
            }
            .footer1{
              margin-top: 10%;
            }
            </style>
    </head>
<body>
    <table style="" >
        <tr style="border: #fff">
            <td style="width:20%;border:0px solid #d3d3d3;"></td>
            <td style="width:50%;border:0px solid #d3d3d3;" >
            <span style="font-size: 15px;"> SI Department. Centre for Plant Medicine Research </span>
            </td>
            <td style="width:10%;border:0px solid #d3d3d3;"></td>
    
        </tr>
    </table>
    <table style="margin-top:-1%" >
        <tr style="border:0px solid #d3d3d3;">
            <td style="width:17%; border:0px solid #d3d3d3;"></td>
            <td style="border:0px solid #d3d3d3;">
                <span style="font-size: 13px;">  Number of Drug Analysis Report Completed from {{ date("F Y", strtotime($from_date)) }} to {{ date("F Y", strtotime($to_date)) }}</span>
            </td>
            <td style="width:15%; border:0px solid #d3d3d3;"></td>


        </tr>
    </table>
    <table >
        <tr>
            <th>#</th>
            <th>Product Type</th>
            <th>Number of Product Received</th>
            <th>Number of Product Analysed</th>
        </tr>

        <tbody>
          @if ($single_multiple_lab == Null)
          @php $i=0; @endphp
          @foreach ($product_types as $product_type)                                    
           <tr>
           <td class="font">{{$i}} </td>
           <td class="font"> {{$product_type->name}} </td>
           <td class="font"> 
              {{count($product_type['pending'])}}
           </td>
           <td class="font"> 
              {{count($product_type['completed'])}}
           </td>
           </tr>
          @php
             $i++; 
          @endphp
          @endforeach
          @endif 


          @if ($single_multiple_lab == 1)
                    @php $i=0; @endphp
          @foreach ($product_types as $product_type)                                    
           <tr>
           <td class="font">{{$i}} </td>
           <td class="font"> {{$product_type->name}} </td>
           <td class="font"> 
              {{count($product_type['singlelabpending'])}}
           </td>
           <td class="font"> 
              {{count($product_type['singlelabcompleted'])}}
           </td>
           </tr>
          @php
             $i++; 
          @endphp
          @endforeach
          @endif 

          @if ($single_multiple_lab == 2)
                   @php $i=0; @endphp
          @foreach ($product_types as $product_type)                                    
           <tr>
           <td class="font">{{$i}} </td>
           <td class="font"> {{$product_type->name}} </td>
           <td class="font"> 
              {{count($product_type['multiplelabpending'])}}
           </td>
           <td class="font"> 
              {{count($product_type['multiplelabcompleted'])}}
           </td>
           </tr>
          @php
             $i++; 
          @endphp
          @endforeach
          @endif

          @if ($single_multiple_lab == 3)
           @php $i=0; @endphp
          @foreach ($product_types as $product_type)                                    
           <tr>
           <td class="font">{{$i}} </td>
           <td class="font"> {{$product_type->name}} </td>
           <td class="font"> 
              {{count($product_type['all_labpending'])}}
           </td>
           <td class="font"> 
              {{count($product_type['all_labcompleted'])}}
           </td>
           </tr>
          @php
             $i++; 
          @endphp
          @endforeach
          @endif
           
       </tbody>
    </table>
</body>
</html>
