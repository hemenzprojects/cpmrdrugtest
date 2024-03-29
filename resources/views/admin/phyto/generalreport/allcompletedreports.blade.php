@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="page-header">
     
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="text-center" style="margin: 2%"> 
                    <h4 class="font" style="font-size:18px">List of completed reports</h4>
                   <p class="card-subtitle"> Bellow are all completed report on all received products</p>
                  </div>
            
            </div>
                  <div class="card">
                            <div class="card-header row">
                                    <div class="card-body">
                                        <table id="order-table" class="table table-striped table-bordered table dataTable" style="overflow-x:scroll">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Tests conducted</th>
                                                    <th>Assigned To</th>
                                                    <th>Approvals</th>
                                                    <th>Grade</th>
                                                    <th>Date Analysed</th>  
                                                    <th>Action</th>                  
                                                </tr>
                                            </thead> 
                                            <tbody> 
                                                @foreach ($all_completed_products as $completed_product)                                      
                                                <tr>
                                                <td> 
                                                    <div class="">
                                                        <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="evaluated_product[]" class="custom-control-input" value="{{$completed_product->id}}">
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="font">
                                                    <span style="color: #0e9059">
                                                    {{$completed_product->code}} 
                                                   </span>
       
                                                </td>
                                                <td class="font">
                                                @foreach ($completed_product->organolipticReport->groupBy('id')->first() as $item)
                                                 {{  (\App\PhytoTestConducted::find($item->phyto_testconducted_id)? \App\PhytoTestConducted::find($item->phyto_testconducted_id)->name:'')}}
                                                @endforeach <br>

                                                @foreach ($completed_product->phytochemdataReport->groupBy('id')->first() as $item)
                                                {{ (\App\PhytoTestConducted::find($item->phyto_testconducted_id)? \App\PhytoTestConducted::find($item->phyto_testconducted_id)->name:'')}}
                                                @endforeach <br>
                                                
                                                @foreach ($completed_product->phytochemconstReport->groupBy('id')->first() as $item)
                                                {{  (\App\PhytoTestConducted::find($item->phyto_testconducted_id)? \App\PhytoTestConducted::find($item->phyto_testconducted_id)->name:'')}}
                                                @endforeach <br>
                                               </td>
                                                <td class="font">
                                                    {{  (\App\Admin::find($completed_product->phyto_analysed_by)? \App\Admin::find($completed_product->phyto_analysed_by)->full_name:'')}}
                                                </td>
                                                  <td>
                                                    {{  (\App\Admin::find($completed_product->phyto_approved_by)? \App\Admin::find($completed_product->phyto_approved_by)->full_name:'')}}<br>
                                                    {{  (\App\Admin::find($completed_product->phyto_finalapproved_by)? \App\Admin::find($completed_product->phyto_finalapproved_by)->full_name:'')}}
                                                  </td>
                                                {{-- <td class="font">                               
                                                     {!! $completed_product->phy_hod_evaluation !!}
                                                </td> --}}

                                                
                                                <td class=""> 
                                                    @if ($completed_product->phyto_grade != Null)
                                                    <strong>{!! $completed_product->phyto_grade_report !!}</strong>
                                                    @endif
                                                 </td>

                                                <td class="font"> 
                                                    {{$completed_product->phyto_dateanalysed}}
                                                </td>
                                                <td class="font">
                                                <a href="{{url('admin/phyto/completedreport/show',['id' => $completed_product->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
                                                <span class="font" style="margin-top:10px">
                                                    <a href="{{route('admin.phyto.report.pdf',['id' => $completed_product->id])}}">
                                                        <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                                      </a>
                                                       
                                                  </span>
                                                </td>
                                                </tr>
                                            @endforeach 
                                            </tbody>
                                        </table>
                                   
                                    </div> 
                                
                                </div>
                        </div>
                
                    </div>
                </div>
        
    </div>
</div>
@endsection