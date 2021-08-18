


@if ($single_multiple_lab == 0)
@php 
$total = 0;
@endphp
    @foreach ($product_types as $product_type) 
    
    <?php 
     $p = count($product_type['pending']);

     $total += ($p);
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
   $total += ($p);
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
 $total += ($p);
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
$total += ($p);
?>

@endforeach

{{$total}}
@endif