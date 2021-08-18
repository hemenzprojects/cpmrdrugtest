   

@if ($single_multiple_lab == 0)
@php 
$total = 0;
@endphp
    @foreach ($product_types as $product_type) 
    
    <?php 
     $c = count($product_type['completed']);
     $total += ($c);
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
   $c = count($product_type['singlelabcompleted']);
   $total += ($c);
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
 $c = count($product_type['multiplelabcompleted']);
 $total += ($c);
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
$c = count($product_type['all_labcompleted']);

$total += ($c);
?>

@endforeach

{{$total}}
@endif     