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
            @foreach ($final_reports['completed'] as $final_report) 
             <tr>
                                         
             <td class="font">
                <span style="color: #0e9059">
                    {{$final_report->code}} 
                   </span>
            </td>
             <td class="font"> 
               {{$final_report->name}} 
            </td>

             <td class="font">
                 @if ($final_report->micro_hod_evaluation == 2)
                 <a target="_blank" href="{{ route('admin.sid.print_microreport',['id' => $final_report->id]) }}">
                    <button type="button" class="btn btn-outline-success btn-rounded">Print Report</button>
                </a><br><br>
                <a href="{{route('admin.sid.microreport.pdf',['id' => $final_report->id])}}">
                    <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                  </a>
                 @endif
          
           </td>
             <td class="font">
              @if ($final_report->phyto_hod_evaluation == 2)
              <a  target="_blank" href="{{route('admin.sid.print_pharmreport',['id' => $final_report->id])}}">
                <button type="button" class="btn btn-outline-success btn-rounded">Print Report</button>
            </a><br><br>
            <a href="{{route('admin.sid.pharmreport.pdf',['id' => $final_report->id])}}">
                <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
              </a>   
              @endif
                   
            </td>
             <td class="font">
              @if ($final_report->pharm_hod_evaluation == 2)
              <a  target="_blank" href="{{route('admin.sid.print_phytoreport',['id' => $final_report->id])}}">
                <button type="button" class="btn btn-outline-success btn-rounded"></i>Print Report</button>
               </a><br><br>
               <a href="{{route('admin.sid.phytoreport.pdf',['id' => $final_report->id])}}">
                   <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                 </a>
              @endif
                </td>
             <td class="font">
            
              
                 <a  target="_blank" href="{{url('admin/sid/final_reports/show',['id' => $final_report->id])}}">
                     <button type="button" class="btn btn-info"><i class="ik ik-share"></i>Print All</button>
                 </a>
                 
                    
            </td>

             </tr>
           
             @endforeach
            
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