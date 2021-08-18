
@if ($single_multiple_lab == 0)
@php 
$total = 0;
@endphp
    @foreach ($product_types as $product_type) 
    
    <?php 
     $p = count($product_type['pending']);
     $c = count($product_type['completed']);

     $total += ($p + $c);
     ?>
    
 @endforeach
 
    {{$total}}
@endif   

@if ($single_multiple_lab == 1)
@php 
$total = 0;
@endphp
  @foreach ($product_types as $product_type) 
  
  <?php 
   $p = count($product_type['singlelabpending']);
   $c = count($product_type['singlelabcompleted']);

   $total += ($p + $c);
   ?>
  
@endforeach

  {{$total}}
@endif  

@if ($single_multiple_lab == 2)
@php 
$total = 0;
@endphp
@foreach ($product_types as $product_type) 

<?php 
 $p = count($product_type['multiplelabpending']);
 $c = count($product_type['multiplelabcompleted']);

 $total += ($p + $c);
 ?>

@endforeach

{{$total}}
@endif  

@if ($single_multiple_lab == 3)
@php 
$total = 0;
@endphp
@foreach ($product_types as $product_type) 

<?php 
$p = count($product_type['all_labpending']);
$c = count($product_type['all_labcompleted']);

$total += ($p + $c);
?>

@endforeach

{{$total}}
@endif