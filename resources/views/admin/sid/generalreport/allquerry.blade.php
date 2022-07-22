
<!DOCTYPE html>
<html>
<head>
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
  /* background-color: #dddddd; */
}
</style>
</head>
<body>
    @foreach ($reportquerry  as $reportquerrys) 
<h3 style=" text-align: center;  text-transform: uppercase;">{{$reportquerrys->name}}</h3>
 
<table>
  <tr>
      <th>Company Code</th>
      <th>Customer Name</th>
      <th>Company Name</th>
      <th>Tell</th>
  </tr>
  <tr>
   
    <tr>
      <td>{{$reportquerrys->code}}
          
    </td>
      <td>{{$reportquerrys->name}}</td>
      <td>{{$reportquerrys->company_name}}</td>
      <td>{{$reportquerrys->company_phone}}</td>
    </tr>
  
  </tr>
</table><br>

  <h3 style=" text-align: center; "> PRODUCT DETAILS</h3>
  <table style="margin-bottom: 100PX">
    <tr>
      <th>Product Code</th>
      <th>Product Name</th>
      <th>Quantity</th>
    </tr>
    @foreach ($reportquerrys->product as $item)
    <tr>
        <td>{{$item->code}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->quantity}}</td>
    </tr>
    @endforeach
  </table>
@endforeach
</body>
</html>


