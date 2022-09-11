@extends('admin.layout.main')

@section('content')
 
<div class="">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Archived Reports</h5>
                        <span>Bellow shows all archived reports for all labs</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Archived Reports</li>
                    </ol>
                </nav>
            </div>
        </div>
        
    </div>
   
<div class="row">
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
        
            <div class="row align-items-center">
                <div class="col-md-12">
                  
                    {{ Form::open(array('action'=>"AdminAuth\SID\SIDController@yearlyreport_history", 'method'=>'post','class'=>'form-horizontal')) }}
                    {{Form::token()}}
                    <div class="input-group" style=" margin-top: 10px;">
                        {{ Form::selectRange('year',date('Y') -1, date('Y'), isset($year) ?? $year, array('class'=>'form-','placeholder'=>'Select year')) }}
                        <button type="submit" class="btn btn-primay mr-2">Search</button>    
                    </span>
                    </div>
                    {{ Form::close() }} 
                    <form  id="sidarchiveproduct" action="{{url('admin/sid/reject/archivedreport')}}" class="forms-sample" method="POST">
                        {{ csrf_field() }}
                        <div class="text-center"> 
                            <h4 class="card-title mt-10"> {{$curentyear}} Archived Reports</h4>                           
                        </div>

                     <table id="order-table_micro" class="table table-striped table-bordered nowrap dataTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                {{-- <th>download</th> --}}
                                <th>Lab Status</th>
                                <th>Date Received</th>
                                <th>Date Completed</th>
                                <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>                                                
                            @foreach($report_history as $product)
                            <tr>
                              
                            <td class="font">
                                <a target="blank" href="{{route('admin.sid.product.show', ['id' => $product->id])}}">
                                 

                                    @if ($product->archive == Null)
                                    <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                        {{$product->code}}
                                    </span>  
                                    @else
                                    <span  class="badge  pull-right" style="background-color:#28a745; color:#fff">
                                        <span style="font-size: 0.1px">#completed</span> {{$product->code}}
                                    </span>  
                                    @endif
                                </a>
                                @if($product->single_multiple_lab ==1)
                                <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#S</span></sup>
                                @endif
                                @if($product->single_multiple_lab ==2)
                                <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#M</span></sup>
                                @endif
                            </td>
                            
                            <td class="font">{{$product->name}}
                                
                            </td>
                            {{-- <td class="font">

                                <div class="row">
                                    @if ($product->micro_hod_evaluation == 2)
                                    <div class="col-md-6">
                                        <a  target="_blank" href="{{route('admin.sid.print_microreport',['id' => $product->id])}}">
                                            <button type="button" class="btn btn-outline-success btn-rounded">View Report</button>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{route('admin.sid.microreport.pdf',['id' => $product->id])}}">
                                            <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                          </a>
                                    </div>
                                    @endif
                                </div>

                            </td> --}}
                            <td>
                                
                                @foreach ($product->ProductDept->where('dept_id',1)->where('status','>', 0) as $item)
                                 @if ($item->status == 4)
                                 <a href="#!" title="Micro"><i class="ik ik-check f-16 mr-15 text-green"></i></a>
                                 @else
                                 <a href="#!" title="Micro"><i class="ik ik-x  f-16 mr-15 text-red"></i></a>
                                 @endif
                                @endforeach

                                @foreach ($product->ProductDept->where('dept_id',2)->where('status','>', 0) as $item)
                                 @if ($item->status == 8)
                                 <a href="#!" title="Pharm"><i class="ik ik-check f-16 mr-15 text-green"></i></a>
                                 @else
                                 <a href="#!" title="Pharm"><i class="ik ik-x  f-16 mr-15 text-red"></i></a>
                                 @endif
                                @endforeach

                                @foreach ($product->ProductDept->where('dept_id',3)->where('status','>', 0) as $item)
                                @if ($item->status == 4)
                                <a href="#!" title="Phyto"><i class="ik ik-check f-16 mr-15 text-green"></i></a>
                                @else
                                <a href="#!" title="Phyto"><i class="ik ik-x  f-16 mr-15 text-red"></i></a>
                                @endif
                               @endforeach

                            </td>
                            <td class="font">
                                @foreach ($product->ProductDept as $item)
                                <ul><li style="font-size:10px">  {{$item->created_at}}</li></ul>   
                                @endforeach
                            </td>
                            <td class="font">
                          {{$product->micro_reportdatecompleted}} 
                          </td>
                         
                            <td class="font">
                                <div class="form-check mx-sm-2">
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input sidarchiveselect" name=""  value="{{$product->id}}" >
                                        <span class="custom-control-label">&nbsp; </span>
                                    </label>
                                </div>
                            </td>

                            </tr>
                           
                            @endforeach
                        </tbody>
                    </table>
                      <select name="condition" id="">
                          <option value="">Reject Archived Report</option>
                      </select>
                      <button onclick="return confirm('Please comfirm selected items .')"  class="" type="submit"> Reject</button>
                    </form>
 
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>



@endsection