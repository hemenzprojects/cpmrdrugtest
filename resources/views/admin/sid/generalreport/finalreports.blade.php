@extends('admin.layout.main')

@section('content')
 
<div class="container-fluid">
    <div class="card">
        <div class="text-center"> 
            <h4 class="font" style="font-size:18px; margin-top:20px">List of Final reports on {{\App\ProductType::find($ptype_id)->name}} </h4>
    
           </div>
        <div class="card-body">
            <table id="order-table" class="table table-striped table-bordered nowrap">
         <thead>
         <tr>
             <th>#</th>
             <th>Product</th>
             <th>Microbiology</th>
             <th>Pharmacology</th>
             <th>Phytochemistry</th>
             <th>Print All</th>
         </tr>
         </thead>
         <tbody>

           @if ($single_multiple_lab == 0)
        
           @foreach ($final_reports['completed']->whereIN('id',$completed_reports)  as $final_report) 
               @include('admin.sid.temp.finalreporttemp')
           @endforeach
           @endif
            
           @if ($single_multiple_lab == 1)
           @foreach ($final_reports['singlelabcompleted']->whereIN('id',$singlelab_completed) as $final_report) 
               @include('admin.sid.temp.finalreporttemp')
           @endforeach
           @endif

           @if ($single_multiple_lab == 2)
           @foreach ($final_reports['multiplelabcompleted']->whereIN('id',$multiple_labcompleted)   as $final_report) 
               @include('admin.sid.temp.finalreporttemp')
           @endforeach
           @endif

           @if ($single_multiple_lab == 3)
           @foreach ($final_reports['multiplelabcompleted']->whereIN('id',$all_labcompleted)   as $final_report) 
               @include('admin.sid.temp.finalreporttemp')
           @endforeach
           @endif
         </tbody>
         <tr>
            <th>#</th>
            <th>Product</th>
            <th>Microbiology</th>
            <th>Pharmacology</th>
            <th>Phytochemistry</th>
            <th>#</th>

        </tr>
        </table>
        </div>
    </div>
</div>

@endsection