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
            <td style="width:20%;border: #fff"></td>
            <td style="width:50%; border: #fff" >
            <span style="font-size: 15px;"> SI Department. Centre for Plant Medicine Research </span>
            </td>
            <td style="width:10%; border: #fff"></td>
    
        </tr>
    </table>
    <table style="margin-top:-1%" >
        <tr style="border: #fff">
            <td style="width:40%;border: #fff"></td>
            <td style="width:50%; border: #fff" >
            <span style="font-size: 13px;"> Product Delivery Sheet</span>
            </td>
            <td style="width:10%; border: #fff"></td>
    
        </tr>
    </table>
    <table >
        <tr>
            <th class="font">Product Code</th>
            <th class="font">Product Name</th>
            <th class="font">Date</th>
            <th class="font">Microbiology</th>
            <th class="font">Pharmacology</th>
            <th class="font">Phytochemistry</th>
    
        </tr>
        
        @foreach ($products as $product)
        <tr>
            <td class="font">{{$product->code}}</td>
            <td class="font">{{$product->name}}</td>
            <td class="font"></td>
            <td class="font"></td>
            <td class="font"></td>
            <td class="font"></td>
    
        </tr>
      
        @endforeach
        <tr >
            <td class="font" style="height: 5%">Distributor SIGN:</td>
            <td class="font"></td>
            <td class="font" style="height: 5%">Receiver SIGN:</td>
            <td class="font"></td>
            <td class="font"></td>
            <td class="font"></td>
    
        </tr>
    </table>
</body>
</html>
